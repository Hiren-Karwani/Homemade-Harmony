<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $conn->query("INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
    $_SESSION['user'] = $username;
    
    header("Location: ../index.php");
    exit();
}
?>
