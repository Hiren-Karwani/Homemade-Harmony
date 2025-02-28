<?php
include 'php/config.php';
include 'php/auth_check.php'; // Ensure authentication check

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle scheduling and adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_order'])) {
    $schedule_id = (int)$_POST['schedule_id'];
    $delivery_date = $_POST['delivery_date'];
    $delivery_time = $_POST['delivery_time'];
    $scheduled_delivery = "$delivery_date $delivery_time";

    // Validate date/time
    $now = new DateTime();
    $selected_time = new DateTime($scheduled_delivery);
    if ($selected_time <= $now) {
        $error = "Please select a future date and time!";
    } else {
        // Fetch product_id and price from schedule
        $stmt = $conn->prepare("SELECT product_id, price FROM schedule WHERE id = ?");
        $stmt->bind_param("i", $schedule_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $product_id = $row['product_id']; // Correct product ID
            $price = $row['price'];
            $user_id = $_SESSION['user_id'] ?? 1; // Default to 1 if no user_id, adjust as needed
            
            // Insert into orders table
            $query = "INSERT INTO orders (user_id, product_id, total_price, scheduled_delivery, status, order_date) 
                      VALUES (?, ?, ?, ?, 'Pending', NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iids", $user_id, $product_id, $price, $scheduled_delivery);
            $stmt->execute();
            $stmt->close();

            // Optionally add to cart (if you want to allow cart checkout later)
            $_SESSION['cart'][$schedule_id] = ($_SESSION['cart'][$schedule_id] ?? 0) + 1;

            $success_message = "Order scheduled for $scheduled_delivery!";
        } else {
            $error = "Invalid schedule ID!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Schedule | Homemade Harmony</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="images/logo.jpg">
</head>

<body>

<header>
    <nav class="navbar">
        <a href="#" class="website-name">Homemade Harmony</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="schedule.php">Schedule</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</header>

<!-- 📅 Weekly Schedule -->
<div class="schedule-container">
    <h2>Weekly Tiffin Schedule</h2>

    <?php if (isset($success_message)): ?>
        <p class="success-message"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p class="error-message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <table class="schedule-table">
        <thead>
            <tr>
                <th>Day</th>
                <th>Meal</th>
                <th>Price</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $result = $conn->query("SELECT * FROM schedule ORDER BY id ASC");
            while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <td><?= htmlspecialchars($row['day']) ?></td>
                <td><?= htmlspecialchars($row['meal']) ?></td>
                <td>₹<?= htmlspecialchars($row['price']) ?></td>
                <td>
                    <!-- Order Now button triggers the schedule form -->
                    <button class="order-now" data-id="<?= $row['id'] ?>">Order Now</button>
                    <!-- Hidden schedule form, shown via JS -->
                    <form class="schedule-form" id="form-<?= $row['id'] ?>" method="POST" style="display: none;">
                        <input type="hidden" name="schedule_id" value="<?= $row['id'] ?>">
                        <label for="delivery_date-<?= $row['id'] ?>">Date:</label>
                        <input type="date" id="delivery_date-<?= $row['id'] ?>" name="delivery_date" required>
                        <label for="delivery_time-<?= $row['id'] ?>">Time:</label>
                        <input type="time" id="delivery_time-<?= $row['id'] ?>" name="delivery_time" min="09:00" max="18:00" required>
                        <button type="submit" name="schedule_order">Confirm Schedule</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="js/scripts.js"></script>
<script>
    // Toggle schedule form visibility
    document.querySelectorAll('.order-now').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const form = document.getElementById(`form-${id}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });
    });

    // Set minimum date to today
    document.querySelectorAll('input[type="date"]').forEach(input => {
        const today = new Date().toISOString().split("T")[0];
        input.setAttribute("min", today);
    });
</script>

</body>
</html>