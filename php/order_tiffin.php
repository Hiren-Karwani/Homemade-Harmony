<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "⚠️ Please log in to place an order.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["schedule_id"])) {
    $user_id = $_SESSION['user_id'];
    $schedule_id = intval($_POST["schedule_id"]);

    // Insert order into the database
    $stmt = $conn->prepare("INSERT INTO orders (user_id, schedule_id, order_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("ii", $user_id, $schedule_id);

    if ($stmt->execute()) {
        echo "✅ Order placed successfully!";
    } else {
        echo "❌ Failed to place order. Try again.";
    }

    $stmt->close();
} else {
    echo "❌ Invalid request.";
}
?>
