<?php
session_start();
include 'php/config.php';
include 'php/auth_check.php';

// Check if the cart is empty
$cart_empty = !isset($_SESSION['cart']) || empty($_SESSION['cart']);
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
                    
    <div class="cart-item-details">
        <p><strong><?= htmlspecialchars($row['name']); ?></strong></p>
        <p>₹<?= number_format($row['price'], 2); ?> × 
            <input type="number" class="quantity-input" data-id="<?= $id; ?>" value="<?= (int)$quantity; ?>" min="1">
            = ₹<span class="item-total" data-id="<?= $id; ?>"><?= number_format($item_total, 2); ?></span>
        </p>
        <button class="remove-from-cart" data-id="<?= $id; ?>">Remove</button>
    </div>
    </li>
                <?php endif; endforeach; ?>
        </ul>

        <h3>Total Price: ₹<span id="total-price"><?= number_format($total_price, 2); ?></span></h3>
        <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
    <?php endif; ?>
</div>

<!-- Popup Notification -->
<div id="popup-message">Item removed from cart</div>

<script src="js/scripts.js"></script>
<script>
document.querySelectorAll(".quantity-input").forEach(input => {
    input.addEventListener("change", function () {
        let productId = this.getAttribute("data-id");
        let newQuantity = parseInt(this.value);

        if (isNaN(newQuantity) || newQuantity < 1) {
            this.value = 1; // Prevents invalid values
            newQuantity = 1;
        }

        fetch("php/update_cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `product_id=${productId}&quantity=${newQuantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`.item-total[data-id="${productId}"]`).innerText = `${data.new_item_total}`;
                document.querySelector(".checkout-total").innerText = `Total: ${data.total_price}`;
            } else {
                alert("Error updating cart: " + data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    });
});

</script>

</body>
</html>
