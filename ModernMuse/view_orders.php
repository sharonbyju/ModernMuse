<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin'])) {
    header('Location: products.php');
    exit();
}

$stmt = $pdo->prepare("SELECT o.OrderID, o.CustomerID, c.FirstName, c.LastName, c.Email, c.Username FROM Orders o JOIN Customers c ON o.CustomerID = c.CustomerID");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>All Orders</h1>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                        <td><?php echo htmlspecialchars($order['CustomerID']); ?></td>
                        <td><?php echo htmlspecialchars($order['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($order['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($order['Email']); ?></td>
                        <td><?php echo htmlspecialchars($order['Username']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
