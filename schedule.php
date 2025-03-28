<?php
include 'php/config.php';
include 'php/auth_check.php'; // Ensure authentication check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Schedule | Homemade Harmony</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="images/logo.jpg"> <!-- Add your logo here -->
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
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . htmlspecialchars($row['day']) . '</td>
                        <td>' . htmlspecialchars($row['meal']) . '</td>
                        <td>₹' . htmlspecialchars($row['price']) . '</td>
                        <td><button class="order-now" data-id="' . $row['id'] . '">Order Now</button></td>
                      </tr>';
            }
        ?>
        </tbody>
    </table>
</div>


<script src="js/scripts.js"></script>
</body>
</html>
