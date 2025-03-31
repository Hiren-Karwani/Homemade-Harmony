<?php
session_start();
include 'php/config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch pending orders with user details
$pending_orders = $conn->query("
    SELECT orders.id, users.username, users.address, orders.status 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    WHERE orders.status = 'pending'
");

// Fetch rejected or pending requested orders with user details
$requested_orders = $conn->query("
    SELECT orders.id, users.username, users.address, orders.status 
    FROM orders 
    JOIN users ON orders.user_id = users.id 
    WHERE orders.status IN ('pending', 'cancelled')
");

// Fetch products
$products = $conn->query("SELECT * FROM products");

// Fetch schedule
$schedule = $conn->query("SELECT * FROM schedule");

// Fetch completed orders with dates
$completed_orders = $conn->query("SELECT orders.id, users.username, users.address, orders.status, orders.order_date FROM orders JOIN users ON orders.user_id = users.id WHERE orders.status = 'completed'");

// Handle product addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    $conn->query("INSERT INTO products (name, price) VALUES ('$product_name', '$product_price')");
    header("Location: admin_dashboard.php");
    exit();
}

// Handle product deletion
if (isset($_GET['delete_product'])) {
    $product_id = $_GET['delete_product'];
    $conn->query("DELETE FROM products WHERE id='$product_id'");
    header("Location: admin_dashboard.php");
    exit();
}

// Handle updating product price
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_price'])) {
    $product_id = $_POST['product_id'];
    $new_price = $_POST['new_price'];

    $conn->query("UPDATE products SET price='$new_price' WHERE id='$product_id'");
    header("Location: admin_dashboard.php");
    exit();
}

// Handle updating order status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    $conn->query("UPDATE orders SET status='$new_status' WHERE id='$order_id'");
    header("Location: admin_dashboard.php");
    exit();
}

// Handle updating schedule
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_schedule'])) {
    $schedule_id = $_POST['schedule_id'];
    $new_meal = $_POST['new_meal'];
    $new_price = $_POST['new_price'];

    $conn->query("UPDATE schedule SET meal='$new_meal', price='$new_price' WHERE id='$schedule_id'");
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_styles.css">
    <div class="navbar">
    <a href="admin_dashboard.php" class="site-title">Tiffin Service Admin</a>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</head>
<body>

<div class="dashboard-container">

    <!-- Pending Orders Section -->
    <section>
        <h2>Pending Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php while ($order = $pending_orders->fetch_assoc()) : ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['address']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td>
                    <form method="post" action="send_otp.php">
    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
    <select name="new_status" onchange="checkStatus(this, <?= $order['id'] ?>)">
        <option value="completed">Complete</option>
        <option value="cancelled">Reject</option>
    </select>
    <button type="submit" name="update_order_status">Update</button>
</form>

<script>
function checkStatus(select, orderId) {
    if (select.value === "completed") {
        window.location.href = "send_otp.php?order_id=" + orderId;
    }
}
</script>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Requested/Rejection Orders Section -->
    <section>
        <h2>Requested & Rejected Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Username</th>
                <th>Address</th>
                <th>Status</th>
            </tr>
            <?php while ($order = $requested_orders->fetch_assoc()) : ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['address']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Completed Orders Section -->
    <section>
        <h2>Completed Orders</h2>
        <table>
            <tr><th>Order ID</th><th>Username</th><th>Address</th><th>Status</th><th>Completion Date</th></tr>
            <?php while ($order = $completed_orders->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['username']) ?></td>
                    <td><?= htmlspecialchars($order['address']) ?></td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><?= htmlspecialchars($order['order_date']) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Product Management -->
    <section>
        <h2>Manage Products</h2>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($product = $products->fetch_assoc()) : ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                    <td>
                        <a href="?delete_product=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>

        <!-- Add Product Form -->
        <h3>Add New Product</h3>
        <form method="post">
            <input type="text" name="product_name" placeholder="Product Name" required>
            <input type="number" step="0.01" name="product_price" placeholder="Price" required>
            <button type="submit" name="add_product">Add Product</button>
        </form>

        <!-- Update Product Price -->
        <h3>Update Product Price</h3>
        <form method="post">
            <select name="product_id" required>
                <option value="">Select Product</option>
                <?php
                $products = $conn->query("SELECT * FROM products");
                while ($product = $products->fetch_assoc()) {
                    echo "<option value='{$product['id']}'>{$product['name']} - \${$product['price']}</option>";
                }
                ?>
            </select>
            <input type="number" step="0.01" name="new_price" placeholder="New Price" required>
            <button type="submit" name="update_price">Update Price</button>
        </form>
    </section>

    <!-- Schedule Management -->
    <section>
        <h2>Manage Weekly Schedule</h2>
        <table>
            <tr>
                <th>Day</th>
                <th>Meal</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $schedule->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['day']) ?></td>
                    <td><?= htmlspecialchars($row['meal']) ?></td>
                    <td>$<?= number_format($row['price'], 2) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="schedule_id" value="<?= $row['id'] ?>">
                            <input type="text" name="new_meal" value="<?= htmlspecialchars($row['meal']) ?>" required>
                            <input type="number" step="0.01" name="new_price" value="<?= $row['price'] ?>" required>
                            <button type="submit" name="update_schedule">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

</div>

</body>
</html>
