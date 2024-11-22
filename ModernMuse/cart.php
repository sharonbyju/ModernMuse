<?php
session_start();
include 'db.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalAmount = 0;
$cartItems = [];

//if the cart is not empty
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
    <title>Your Cart - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Your Cart</h1>
        <?php if (empty($cartItems)): ?>
            <h2>Your cart is empty. Please add products to your cart.</h2>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $productId => $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>$<?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <form action="update_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['quantity']); ?>" min="1" max="<?php echo htmlspecialchars($item['inventory']); ?>" onchange="checkInventory(<?php echo $item['inventory']; ?>, this)">
                                    <?php if ($item['quantity'] > $item['inventory']): ?>
                                        <span style="color: red;">Max available is <?php echo $item['inventory']; ?></span>
                                    <?php endif; ?>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>
                                <form action="remove_from_cart.php" method="POST">
                                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h2>Total Amount: $<?php echo number_format($totalAmount, 2); ?></h2>
            <a href="checkout.php">Proceed to Checkout</a>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>

    <script>
        function checkInventory(inventory, input) {
            const quantity = parseInt(input.value);
            const errorSpan = input.nextElementSibling;

            if (quantity > inventory) {
                errorSpan.innerText = `Max available is ${inventory}`;
                input.value = inventory; 
            } else {
                errorSpan.innerText = '';
            }
        }
    </script>
</body>
</html>
