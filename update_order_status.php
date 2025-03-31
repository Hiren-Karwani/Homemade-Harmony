<?php
session_start();
include 'php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
        die("OTP verification required! <a href='verify_otp.php'>Verify OTP</a>");
    }

    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    $conn->query("UPDATE orders SET status='$new_status' WHERE id='$order_id'");
    unset($_SESSION['otp_verified']); // Clear OTP session after update

    echo "Order status updated!";
}
?>
