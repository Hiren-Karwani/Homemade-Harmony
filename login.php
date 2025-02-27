<?php
session_start();
include 'php/config.php';

$user_error_message = '';
$admin_error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if (isset($_POST['user_login'])) {
        // User Login
        $result = $conn->query("SELECT * FROM users WHERE username='$username' AND password='$password'");

        if ($result->num_rows > 0) {
            $_SESSION['user'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $user_error_message = "Invalid username or password!";
        }
    } elseif (isset($_POST['admin_login'])) {
        // Admin Login
        $result = $conn->query("SELECT * FROM admins WHERE username='$username' AND password='$password'");

        if ($result->num_rows > 0) {
            $_SESSION['admin'] = $username;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $admin_error_message = "Invalid admin credentials!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

<div class="auth-wrapper">
    <!-- User Login -->
    <div class="auth-container">
        <h2>User Login</h2>
        
        <?php if (!empty($user_error_message)) : ?>
            <p class="error-message"><?= htmlspecialchars($user_error_message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="user_login">Login</button>
        </form>
        <a href="register.php">Create an account</a>
    </div>

    <!-- Admin Login -->
    <div class="auth-container">
        <h2>Admin Login</h2>

        <?php if (!empty($admin_error_message)) : ?>
            <p class="error-message"><?= htmlspecialchars($admin_error_message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Admin Password" required>
            <button type="submit" name="admin_login">Login</button>
        </form>
        <a href="register.php">Create an account</a>
    </div>
</div>

</body>
</html>
