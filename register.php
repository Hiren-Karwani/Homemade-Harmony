<?php
session_start();
include 'php/config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Check if user already exists
    $check_user = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$email'");

    if ($check_user->num_rows > 0) {
        $error_message = "Username or email already taken!";
    } else {
        $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        $_SESSION['user'] = $username;
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="auth-container">
    <h2>Register</h2>

    <?php if (!empty($error_message)) : ?>
        <p class="error-message"><?= htmlspecialchars($error_message) ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
        <p style="display: inline;">Already have an account? <a href="login.php" style="display: inline; padding-top: 10px">Login</a></p>
    </form>
</div>

</body>
</html>
