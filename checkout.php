<?php
include 'php/config.php';
include 'php/auth_check.php';

$order_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    // Order processing logic (e.g., save to database)

    // Clear the cart after order confirmation
    unset($_SESSION['cart']);

    // Redirect to index page after 3 seconds
    header("refresh:3;url=index.php");
    $order_success = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header>
    <nav class="navbar">
        <a href="#" class="website-name">Homemade Harmony</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="index.php">Schedule</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</header>

<div class="checkout-container">
    <h2>Your Order Summary</h2>

    <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="checkout-list">
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $id => $quantity):
                $result = $conn->query("SELECT * FROM products WHERE id=$id");
                if ($row = $result->fetch_assoc()):
                    $subtotal = $row['price'] * $quantity;
                    $total += $subtotal;
            ?>
                <li><?= htmlspecialchars($row['name']); ?> - ₹<?= number_format($row['price'], 2); ?> x <?= $quantity; ?> = ₹<?= number_format($subtotal, 2); ?></li>
            <?php endif; endforeach; ?>
        </ul>
        <p class="checkout-total">Total: ₹<?= number_format($total, 2); ?></p>

        <form method="POST">
            <button type="submit" id="confirm-order" name="confirm_order">Confirm Order</button>
        </form>
    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>

    <?php if ($order_success): ?>
        <p class="success-message">Order placed successfully! Redirecting to home...</p>
    <?php endif; ?>
</div>

<script>
    // Redirect after 3 seconds if order is successful
    <?php if ($order_success): ?>
        setTimeout(() => { window.location.href = "index.php"; }, 3000);
    <?php endif; ?>
</script>

</body>
</html>
