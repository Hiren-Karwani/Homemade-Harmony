<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $type = $_POST['type'] ?? 'product'; // Can be 'product' or 'schedule'

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Fetch product details (based on type: products or schedule)
    if ($type === 'product') {
        $stmt = $conn->prepare("SELECT id, name, price FROM products WHERE id = ?");
    } else {
        $stmt = $conn->prepare("SELECT id, meal AS name, price FROM schedule WHERE id = ?");
    }
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
    $stmt->close();

    if ($item) {
        // If item exists, increase quantity, else add new
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => 1
            ];
        }
        echo json_encode(["status" => "success", "message" => $item['name'] . " added to cart!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid item!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}
?>
