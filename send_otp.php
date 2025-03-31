<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include 'php/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $otp = rand(100000, 999999); // Generate 6-digit OTP
    $_SESSION['otp'] = $otp; // Store OTP in session

    // Create PHPMailer instance
    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change if using another SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Your email
        $mail->Password = 'your-email-password'; // Your email password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('your-email@gmail.com', 'Tiffin Service'); // Sender
        $mail->addAddress($email); // Recipient
        $mail->Subject = "Your OTP for Order Completion";
        $mail->Body = "Your OTP for completing the order is: $otp. This OTP is valid for a short time.";

        // Send email
        $mail->send();
        echo "OTP sent successfully";
    } catch (Exception $e) {
        echo "Error: " . $mail->ErrorInfo;
    }
}
?>
