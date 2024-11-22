<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php');
    exit();
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$cartItems = [];
$totalAmount = 0;

if (!empty($cart)) {
    $placeholders = implode(',', array_fill(0, count($cart), '?'));
    $stmt = $pdo->prepare("SELECT ProductID, ProductName, Price, Inventory FROM Products WHERE ProductID IN ($placeholders)");
    $stmt->execute(array_keys($cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        $cartItems[$product['ProductID']] = [
            'name' => $product['ProductName'],
            'price' => $product['Price'],
            'quantity' => $cart[$product['ProductID']],
            'inventory' => $product['Inventory'],
        ];
    }

    foreach ($cartItems as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ede8de;
        }
        main {
            display: flex;
            padding: 20px;
        }
        .cart-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #d2d4c9;
        }
        button {
            background-color: #79918b;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #907182;
        }
        h2, h3 {
            color: #2c2c2c;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <div style="flex: 1; padding-right: 20px;">
            <h1>Your Order</h1>
            <?php if (empty($cartItems)): ?>
                <h2>Your cart is empty. Please add products to your cart before checking out.</h2>
            <?php else: ?>
                <div class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p>Price: $<?php echo number_format($item['price'], 2); ?></p>
                            <p>Quantity: <?php echo htmlspecialchars($item['quantity']); ?></p>
                            <p>Total: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <h2>Total Amount: $<span id="grandTotal"><?php echo number_format($totalAmount, 2); ?></span></h2>
                <a href="cart.php">Go back to cart to make changes</a>
            <?php endif; ?>
        </div>

        <div style="flex: 1;"><br><br><br><br>
            <h3>Shipping and Billing Information</h3>
            <form id="checkout-form" action="process_checkout.php" method="POST">
                <label for="shipping_address">Shipping Address:</label>
                <textarea name="shipping_address" required></textarea>
                
                <label for="billing_address">Billing Address:</label>
                <textarea name="billing_address" required></textarea>
<br><br>
                <button type="submit">Place Order</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
