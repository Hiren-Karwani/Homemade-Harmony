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
            <input type="text" id="search-bar" placeholder="Search for items...">
            <button class="search-button" onclick="searchProducts()">Search</button>
        </div>
    </nav>
</header>

<!-- 🔍 Search Results Section -->
<div id="search-results" class="search-results"></div>

<!-- 🛒 Product List -->
<div class="products">
<?php
    // Fetch products from the database
    $result = $conn->query("SELECT * FROM products");

    while ($row = $result->fetch_assoc()) {
        echo '<div class="product">
                <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <p>' . htmlspecialchars($row['description']) . '</p> <br>
                <p>₹' . htmlspecialchars($row['price']) . '</p>
                <button class="add-to-cart" data-id="' . $row['id'] . '">Add to Cart</button>
              </div>';
    }
?>
</div>

<script src="js/scripts.js"></script>
</body>
</html>
