<?php
session_start();
include 'db.php';


$productId = $_POST['product_id'];
$newQuantity = $_POST['quantity'];


if (isset($_SESSION['cart'][$productId])) {
    if ($newQuantity > 0) {
        $_SESSION['cart'][$productId] = $newQuantity; // Update quantity
    } else {
        unset($_SESSION['cart'][$productId]); 
    }
}

header('Location: cart.php');
exit();
?>
