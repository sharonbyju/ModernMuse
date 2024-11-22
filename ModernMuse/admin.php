<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: products.php'); // Redirect if not admin
    exit();
}


// Only allow access if logged in as admin
if (!isset($_SESSION['admin_user_id'])) {
    header("Location: login.php");
    exit();
}


$stmt = $pdo->prepare("SELECT * FROM Customers");
$stmt->execute();
$customers = $stmt->fetchAll();


$stmt = $pdo->prepare("SELECT * FROM Orders");
$stmt->execute();
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Admin Dashboard</h1>

        <h2>Customers</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['CustomerID']); ?></td>
                    <td><?php echo htmlspecialchars($customer['FirstName'] . ' ' . $customer['LastName']); ?></td>
                    <td><?php echo htmlspecialchars($customer['Email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h2>Orders</h2>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Total Amount</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                    <td><?php echo htmlspecialchars($order['CustomerID']); ?></td>
                    <td>$<?php echo number_format($order['TotalAmount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
