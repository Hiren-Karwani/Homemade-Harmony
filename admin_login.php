<?php
session_start();
include 'php/config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $result = $conn->query("SELECT * FROM admins WHERE username='$username' AND password='$password'");

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Invalid admin credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <h2>Admin Login</h2>

        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Admin Username" required>
            <input type="password" name="password" placeholder="Admin Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="admin_register.php">Create an account</a>
        <a href="login.php">Back to Login Selection</a>
    </div>
</div>

</body>
</html>
