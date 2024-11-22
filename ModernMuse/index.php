<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to your CSS file -->
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
        </ul>
    </nav>
    <div id="user-status">
        <?php if (isset($_SESSION['username'])): ?>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            <a href="logout.php">Log Out</a>
        <?php else: ?>
            <p><a href="login.php">Sign In/Register</a></p>
        <?php endif; ?>
    </div>
</header>
<main>
    <h1>Welcome to Modern Muse!</h1>
    <p>Your one-stop shop for the latest fashion trends.</p>
    <p><a href="products.php">Browse Products</a></p>
</main>
<footer>
    <p>&copy; 2024 Modern Muse</p>
</footer>
</body>
</html>
