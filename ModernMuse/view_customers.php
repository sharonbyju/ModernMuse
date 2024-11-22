<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin'])) {
    header('Location: products.php');
    exit();
}

$stmt = $pdo->prepare("SELECT CustomerID, FirstName, LastName, Email, Username, Role FROM Customers ORDER BY Role DESC");
$stmt->execute();
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customers - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>All Customers</h1>
        <table>
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['CustomerID']); ?></td>
                        <td><?php echo htmlspecialchars($customer['FirstName']); ?></td>
                        <td><?php echo htmlspecialchars($customer['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($customer['Email']); ?></td>
                        <td><?php echo htmlspecialchars($customer['Username']); ?></td>
                        <td><?php echo htmlspecialchars($customer['Role']); ?></td>
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
