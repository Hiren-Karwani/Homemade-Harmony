<?php
include 'php/config.php';
include 'php/auth_check.php'; // Ensure this file exists in the "php/" folder

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $cart_empty = true;
} else {
    $cart_empty = false;
}

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<header>
<!-- <h1>Your Cart</h1> -->
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

<div class="cart-container">
    <?php if ($cart_empty): ?>
        <p class="empty-cart-message">Your cart is empty 😞</p>
    <?php else: ?>
        <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
            <?php 
            $result = $conn->query("SELECT * FROM products WHERE id=$id");
            $row = $result->fetch_assoc();
            $item_total = $row['price'] * $quantity;
            $total_price += $item_total;
            ?>
            <div class="cart-items">
                <img src="<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['name']); ?>">
                <p><?= htmlspecialchars($row['name']); ?> - ₹<?= number_format($row['price'], 2); ?> x <?= $quantity; ?> = ₹<?= number_format($item_total, 2); ?></p>
                <button class="remove-from-cart" data-id="<?= $id; ?>">Remove</button>
            </div>
        <?php endforeach; ?>

        <h3>Total Price: ₹<?= number_format($total_price, 2); ?></h3>
        <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
    <?php endif; ?>
</div>

<!-- Popup Notification -->
<div id="popup-message">Item removed from cart</div>

<script src="js/scripts.js"></script>
<script>
document.querySelectorAll(".remove-from-cart").forEach(button => {
    button.addEventListener("click", function() {
        let productId = this.getAttribute("data-id");

        fetch("php/remove_from_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "product_id=" + productId
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("popup-message").style.display = "block";
            setTimeout(() => {
                document.getElementById("popup-message").style.opacity = "0";
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            }, 2000);
        });
    });
});
</script>

</body>
</html>
