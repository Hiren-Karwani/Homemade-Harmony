<?php
session_start();
include 'php/config.php';

// Check if OTP and order ID are set in session
if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_expiry']) || !isset($_SESSION['order_id'])) {
    die("OTP not generated. <a href='send_otp.php'>Request a new OTP</a>");
}

// Check if OTP is expired
if (time() > $_SESSION['otp_expiry']) {
    unset($_SESSION['otp']);
    unset($_SESSION['otp_expiry']);
    unset($_SESSION['order_id']);
    die("OTP expired. <a href='send_otp.php'>Request a new OTP</a>");
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        // OTP Verified - Update Order Status
        $order_id = $_SESSION['order_id'];
        $update = $conn->query("UPDATE orders SET status='completed' WHERE id='$order_id'");

        if ($update) {
            // Clear OTP and order ID from session after successful update
            unset($_SESSION['otp']);
            unset($_SESSION['otp_expiry']);
            unset($_SESSION['order_id']);

            // Redirect to admin dashboard
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "❌ Failed to update order status. Please try again.";
        }
    } else {
        echo "❌ Invalid OTP. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
    <h2>Enter OTP to Complete Order</h2>
    <form method="post">
        <input type="text" name="otp" required placeholder="Enter OTP">
        <button type="submit">Verify OTP</button>
    </form>
</body>
</html>
