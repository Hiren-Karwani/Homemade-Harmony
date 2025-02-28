<?php
session_start();
include 'php/config.php';

if (!isset($_GET['payment_id'])) {
    die("<h3 style='color:red;'>Invalid access.</h3>");
}

$payment_id = $_GET['payment_id'];

// Insert payment details into the database
$conn->query("INSERT INTO payments (payment_id, status, amount) VALUES ('$payment_id', 'Success', (SELECT SUM(price * quantity) FROM cart))");

// Clear the cart
unset($_SESSION['cart']);

echo "<h3 style='color:green;'>Payment successful! Your Payment ID: $payment_id</h3>";
echo "<a href='index.php'>Return to Home</a>";
?>
