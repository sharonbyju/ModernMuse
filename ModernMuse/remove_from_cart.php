<?php
session_start();

if (isset($_SESSION['cart']) && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    unset($_SESSION['cart'][$productId]); 
}

header('Location: cart.php');
exit();
?>
