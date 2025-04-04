<?php
// ✅ Start session and check login status
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'php/config.php';
require 'vendor/autoload.php'; // Razorpay SDK
use Razorpay\Api\Api;

$api_key = "rzp_test_V6IqZqJ3GFv3LN"; 
$api_secret = "ozAbr21dHsKITZOApJdd7Mz8";
$api = new Api($api_key, $api_secret);

$subtotal = 0;
$user = $_SESSION['user']; // ✅ Using updated session variable

// ✅ Ensure cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['checkout_error'] = "Your cart is empty. Please add items before checkout.";
    header("Location: cart.php");
    exit;
}

// ✅ Calculate subtotal
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    if ($quantity < 0) {
        $_SESSION['checkout_error'] = "Invalid cart items. Please update your cart.";
        header("Location: cart.php");
        exit;
    }

    // Fetch product details from DB
    $query = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
    $query->bind_param("i", $product_id);
    $query->execute();
    $result = $query->get_result();

    if ($row = $result->fetch_assoc()) {
        $subtotal += $row['price'] * $quantity;
    }
}

// ✅ Check minimum order amount
if ($subtotal < 1) {
    $_SESSION['checkout_error'] = "Order amount must be at least ₹1. Please add more items.";
    header("Location: cart.php");
    exit;
}

// ✅ Calculate additional charges
$tax = round($subtotal * 0.05, 2); // 5% GST
$delivery_charge = 30; // Fixed delivery charge
$grand_total = $subtotal + $tax + $delivery_charge;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<header>
    <nav class="navbar">
        <a href="#" class="website-name">Homemade Harmony</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>
</header>

<div class="checkout-container">
    <h2>Your Order Summary</h2>

    <?php if (isset($_SESSION['checkout_error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_SESSION['checkout_error']); ?></p>
        <?php unset($_SESSION['checkout_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="checkout-list">
            <?php
            foreach ($_SESSION['cart'] as $product_id => $quantity):
                $query = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
                $query->bind_param("i", $product_id);
                $query->execute();
                $result = $query->get_result();
                
                if ($row = $result->fetch_assoc()):
                    $item_total = $row['price'] * $quantity;
            ?>
                <li>
                    <?= htmlspecialchars($row['name']); ?> - ₹<?= number_format($row['price'], 2); ?> 
                    × <?= (int)$quantity; ?> = ₹<?= number_format($item_total, 2); ?>
                </li>
            <?php endif; endforeach; ?>
        </ul>

        <div class="checkout-summary">
            <p>Subtotal: <strong>₹<?= number_format($subtotal, 2); ?></strong></p>
            <p>Tax (5% GST): <strong>₹<?= number_format($tax, 2); ?></strong></p>
            <p>Delivery Charges: <strong>₹<?= number_format($delivery_charge, 2); ?></strong></p>
            <p class="checkout-total"><strong>Grand Total: ₹<?= number_format($grand_total, 2); ?></strong></p>
        </div>

        <button id="pay-now">Pay Now</button>
        <button id="pay-later">Cash On Delivery</button>

        <script>
            var options = {
                "key": "<?= $api_key ?>",
                "amount": "<?= $grand_total * 100 ?>",
                "currency": "INR",
                "name": "Homemade Harmony",
                "description": "Order Payment",
                "handler": function (response) {
                    window.location.href = "payment_success.php?payment_id=" + response.razorpay_payment_id;
                },
                "theme": {
                    "color": "#0077b6"
                }
            };

            var rzp1 = new Razorpay(options);
            document.getElementById('pay-now').onclick = function (e) {
                rzp1.open();
                e.preventDefault();
            };

            // ✅ Pay Later (Cash on Delivery)
            document.getElementById('pay-later').addEventListener('click', function () {
    fetch('insert_order.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'include',  // ✅ Ensures session is sent
        body: JSON.stringify({
            user: "<?= $_SESSION['user'] ?>",
            schedule_id: 1,
            total_amount: <?= $grand_total ?>,
            payment_method: "COD"
        })
    })
    .then(response => response.text()) // ✅ Read response as text to catch errors
    .then(text => {
        console.log("Raw response:", text);  // ✅ Check actual response
        try {
            let data = JSON.parse(text);
            if (data.success) {
                window.location.href = "index.php";
            } else {
                alert("Error placing order: " + data.message);
            }
        } catch (error) {
            console.error("JSON Parsing Error:", error);
            alert("Unexpected error. Check console for details.");
        }
    })
    .catch(error => console.error("Network error:", error));
});
        </script>

    <?php else: ?>
        <p class="empty-cart">Your cart is empty.</p>
    <?php endif; ?>
</div>

</body>
</html>
