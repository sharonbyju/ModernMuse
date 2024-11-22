<?php
session_start();
include 'db.php';

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalAmount = 0;

if (!empty($cart)) {
    foreach ($cart as $productId => $quantity) {
        $stmt = $pdo->prepare("SELECT Price, Inventory FROM Products WHERE ProductID = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            $totalAmount += $product['Price'] * $quantity;

            $newInventory = $product['Inventory'] - $quantity;
            $updateStmt = $pdo->prepare("UPDATE Products SET Inventory = ? WHERE ProductID = ?");
            $updateStmt->execute([$newInventory, $productId]);
        }
    }

    $shippingAddress = $_POST['shipping_address'];
    $billingAddress = $_POST['billing_address'];

    $stmt = $pdo->prepare("INSERT INTO Orders (CustomerID, TotalAmount, ShippingAddress, BillingAddress) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_SESSION['customer_id'], $totalAmount, $shippingAddress, $billingAddress]);
    $orderId = $pdo->lastInsertId();

    foreach ($cart as $productId => $quantity) {
        $stmt = $pdo->prepare("SELECT Price FROM Products WHERE ProductID = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product) {
            $stmt = $pdo->prepare("INSERT INTO OrderDetails (OrderID, ProductID, Quantity, Price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$orderId, $productId, $quantity, $product['Price']]);
        }
    }

    unset($_SESSION['cart']); 

    header('Location: order_confirmation.php');
    exit();
} else {
    header('Location: cart.php'); 
    exit();
}
?>
