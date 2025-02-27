<?php
include 'php/config.php';
include 'php/auth_check.php'; // Ensure this file exists in the "php/" folder
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Homemade Harmony</title>
    <link rel="stylesheet" href="css/styles1.css">
    <link rel="icon" type="image/png" href="images/logo.jpg"> <!-- Add your logo here -->
</head>

<body>

<header>
    <nav class="navbar">
        <a href="#" class="website-name">Homemade Harmony</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="cart.php">Cart</a>
            <a href="checkout.php">Checkout</a>
            <a href="login.php">Login</a>
        </div>
    </nav>
</header>

<!-- Hero Section -->
<section class="hero">
    <h1>Fresh, Homemade Tiffins Delivered to Your Doorstep</h1>
    <p>Healthy, affordable, and delicious meals made with love.</p>
    <a href="#products" class="btn-order">Order Now</a>
</section>

<script src="js/scripts.js"></script>
</body>
</html>
