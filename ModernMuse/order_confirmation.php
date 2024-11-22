<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Order Confirmation</h1>
        <p>Your order has been placed successfully!</p>
        <p><a href="order_history.php">View Order History</a></p>
        <p><a href="products.php">Continue Shopping</a></p>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
