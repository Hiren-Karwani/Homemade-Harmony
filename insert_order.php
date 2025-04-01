<?php
// ✅ Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'php/config.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "User not logged in."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Invalid JSON received."]);
    exit;
}

$user_id = 1;
$schedule_id =  1;
$total_amount = floatval($data['total_amount'] ?? 0);
$payment_method = $data['payment_method'] ?? "COD";
$order_date = date("Y-m-d H:i:s");
$status = "pending";
$status = "pending";   

// ✅ Ensure user ID and total amount are valid
if (empty($user_id) || $total_amount <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid user or order amount."]);
    exit;
}

// ✅ Insert order into database
$stmt = $conn->prepare("INSERT INTO orders (user_id, schedule_id, order_date, status, total_amount, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iissds", $user_id, $schedule_id, $order_date, $status, $total_amount, $payment_method);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Database error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
