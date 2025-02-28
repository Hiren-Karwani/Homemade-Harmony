<?php
session_start();
include 'php/config.php';
include 'php/auth_check.php'; // Ensure this file exists

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

<div class="cart-container">
    <h2>Your Shopping Cart</h2>

    <?php if ($cart_empty): ?>
        <p class="empty-cart-message">Your cart is empty 😞</p>
    <?php else: ?>
        <ul class="cart-list">
            <?php foreach ($_SESSION['cart'] as $id => $quantity): ?>
                <?php 
                // Fetch product details securely
                $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($row = $result->fetch_assoc()):
                    $item_total = $row['price'] * (int)$quantity;
                    $total_price += $item_total;
                ?>
                    <li class="cart-item">
    <div class="cart-item-details">
        <p><strong><?= htmlspecialchars($row['name']); ?></strong></p>
        <p>₹<?= number_format($row['price'], 2); ?> × <?= (int)$quantity; ?> = ₹<?= number_format($item_total, 2); ?></p>
        <button class="remove-from-cart" data-id="<?= $id; ?>">Remove</button>
    </div>
</li>

                <?php endif; endforeach; ?>
        </ul>

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
                }, 500);
            }, 1000);
        });
    });
});
</script>

</body>
</html>
