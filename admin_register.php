<?php
session_start();
include 'php/config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match!";
    } else {
        // Check if admin username already exists
        $check_admin = $conn->query("SELECT * FROM admins WHERE username='$username'");

        if ($check_admin->num_rows > 0) {
            $error_message = "Username already taken!";
        } else {
            // Encrypt password using MD5 (Consider using bcrypt for better security)
            $hashed_password = md5($password);
            
            // Insert new admin
            $insert = $conn->query("INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')");

            if ($insert) {
                // Redirect to admin login page after successful registration
                header("Location: admin_login.php");
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
    <title>Admin Register</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <h2>Admin Register</h2>

        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="admin_login.php">Already have an account? Login</a>
        <a href="login.php">Back to Login Selection</a>
    </div>
</div>

</body>
</html>
