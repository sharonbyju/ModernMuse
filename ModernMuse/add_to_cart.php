<?php
session_start();
include 'db.php';

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantityToAdd = (int)$_POST['quantity'];

    $stmt = $pdo->prepare("SELECT Inventory FROM Products WHERE ProductID = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if ($product) {
        $inventory = (int)$product['Inventory'];

        if ($quantityToAdd > $inventory) {
            $_SESSION['error'] = "Max amount to order is $inventory.";
        } else {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId] += $quantityToAdd;
            } else {
                $_SESSION['cart'][$productId] = $quantityToAdd;
            }
        }
    } else {
        $_SESSION['error'] = "Product not found.";
    }
}

header('Location: products.php');
exit();
