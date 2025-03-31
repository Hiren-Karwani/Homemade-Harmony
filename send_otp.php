<?php
session_start();
include 'php/config.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    if (!isset($_POST['order_id'])) {
        die("Error: Order ID not provided.");
    }

    $order_id = $_POST['order_id']; // Get order ID from the form submission

    // Fetch user's email based on the order ID
    $result = $conn->query("SELECT users.email FROM orders JOIN users ON orders.user_id = users.id WHERE orders.id = '$order_id'");
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_email = $row['email'];
    } else {
        die("Error: User email not found.");
    }

    // SMTP Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'karwanih21@gmail.com'; // Your Gmail
    $mail->Password = 'ytgd vezs rxkr xcid'; // Use App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Generate OTP and store it in session
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_expiry'] = time() + (5 * 60); // OTP valid for 5 minutes
    $_SESSION['order_id'] = $order_id; // Store order ID for verification later

    // Email Content
    $mail->setFrom('karwanih21@gmail.com', 'Tiffin Service');
    $mail->addAddress($user_email);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body = "Your OTP code is <b>$otp</b>. It is valid for 5 minutes.";

    $mail->send();

    // Redirect to OTP verification page
    header("Location: verify_otp.php");
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
