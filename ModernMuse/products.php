<?php
session_start();
include 'db.php';

// Fetch all product details from the database
$stmt = $pdo->prepare("SELECT ProductID, Brand, ProductName, Price, Inventory, Color, Size FROM Products");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Product Catalog</h1>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <div class="product-list">
            <?php if ($products): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <h2><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                        <p>Brand: <?php echo htmlspecialchars($product['Brand']); ?></p>
                        <p>Price: $<?php echo htmlspecialchars(number_format($product['Price'], 2)); ?></p>
                        <p>Color: <span class="color-sample" style="background-color: <?php echo htmlspecialchars($product['Color']); ?>;"></span></p>
                        <p>Size: <?php echo htmlspecialchars($product['Size']); ?></p> <!-- Displaying size dynamically -->

                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                            <p>Inventory: <?php echo htmlspecialchars($product['Inventory']); ?></p>
                            <p><a href="edit_product.php?product_id=<?php echo htmlspecialchars($product['ProductID']); ?>">Edit Inventory</a></p> <!-- Edit link -->
                        <?php endif; ?>

                        <?php if ($product['Inventory'] > 0): ?>
                            <form action="add_to_cart.php" method="POST" class="add-to-cart-form">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductID']); ?>">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo htmlspecialchars($product['Inventory']); ?>" class="quantity-input">
                                <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                            </form>
                        <?php else: ?>
                            <p style="color: red;">Product out of stock</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h2>No products found.</h2>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
