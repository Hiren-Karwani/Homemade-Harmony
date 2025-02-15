<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect user if not logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
