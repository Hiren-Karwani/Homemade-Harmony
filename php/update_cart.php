<?php
session_start();
include 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = max(1, intval($_POST['quantity']));

    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['cart'][$product_id] = $quantity;
        $new_item_total = $row['price'] * $quantity;

        // ✅ Calculate total cart value
        $total_price = 0;
        foreach ($_SESSION['cart'] as $id => $qty) {
            $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($r = $res->fetch_assoc()) {
                $total_price += $r['price'] * $qty;
            }
        }

        echo json_encode([
            "success" => true,
            "new_item_total" => number_format($new_item_total, 2, '.', ''),
            "total_price" => number_format($total_price, 2, '.', '')
        ]);
        exit;
    }
}

echo json_encode(["success" => false, "error" => "Invalid product ID"]);
?>
