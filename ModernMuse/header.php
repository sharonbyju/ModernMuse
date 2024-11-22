<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="images/logo.png" alt="Modern Muse Logo">
    </div>
    <nav>
        <ul>
            <li><a href="products.php">View Products</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="order_history.php">Order History</a></li>
            <?php if (isset($_SESSION['is_admin'])): ?>
                <li><a href="view_customers.php">View Customers</a></li>
                <li><a href="view_orders.php">View Orders</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div id="user-status">
        <?php if (isset($_SESSION['customer_id'])): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="logout.php">Log Out</a>
        <?php else: ?>
            <p><a href="login.php">Sign In/Register</a></p>
        <?php endif; ?>
    </div>
</header>
