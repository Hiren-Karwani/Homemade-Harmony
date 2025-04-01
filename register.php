<?php
session_start();
include 'php/config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);

    if (empty($username) || empty($password) || empty($confirm_password) || empty($address) || empty($phone)) {
        $error_message = "All fields are required!";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $error_message = "Phone number must be exactly 10 digits!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if username already exists
        $check_user = $conn->query("SELECT * FROM users WHERE username='$username'");

        if ($check_user->num_rows > 0) {
            $error_message = "Username already taken!";
        } else {
            // Encrypt password using MD5 (Consider using bcrypt for better security)
            $hashed_password = md5($password);
            
            // Insert new user
            $insert = $conn->query("INSERT INTO users (username, password, address, phone) VALUES ('$username', '$hashed_password', '$address', '$phone')");

            if ($insert) {
                // Redirect to login page after successful registration
                header("Location: user_login.php");
                exit();
            } else {
                $error_message = "Something went wrong. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <h2>Register</h2>

        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required pattern="[0-9]{10}" title="Enter exactly 10 digits">
            <button type="submit">Register</button>
        </form>
        <a href="user_login.php">Already have an account? Login</a>
        <a href="login.php">Back to Login Selection</a>
    </div>
</div>

</body>
</html>
