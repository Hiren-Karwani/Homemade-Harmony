<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    // Show a popup message and redirect to cart
    echo "<script>
            alert('Item removed from cart!');
            window.location.href='cart.php';
          </script>";
}
?>