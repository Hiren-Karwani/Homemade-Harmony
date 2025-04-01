<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Selection</title>
    <link rel="stylesheet" href="css/styles2.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="auth-container">
        <h2>Select Login Type</h2>
        <div class="button-group">
            <button class="login-btn user" onclick="location.href='user_login.php'">User Login</button>
            <button class="login-btn admin" onclick="location.href='admin_login.php'">Admin Login</button>
        </div>
    </div>
</div>

</body>
</html>
