<?php
session_start();
include 'db.php';

if (!isset($_SESSION['customer_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM Orders WHERE CustomerID = ?");
$stmt->execute([$_SESSION['customer_id']]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Order History</h1>
        <?php if ($orders): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Shipping Address</th>
                        <th>Billing Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                            <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                            <td><?php echo htmlspecialchars($order['TotalAmount']); ?></td>
                            <td><?php echo htmlspecialchars($order['ShippingAddress']); ?></td>
                            <td><?php echo htmlspecialchars($order['BillingAddress']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
