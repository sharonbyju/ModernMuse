<?php
session_start();
include 'db.php';

if (!isset($_SESSION['is_admin'])) {
    header('Location: products.php');
    exit();
}

if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']);
    $stmt = $pdo->prepare("SELECT * FROM Products WHERE ProductID = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        echo "Product not found.";
        exit();
    }
} else {
    header('Location: view_products.php'); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newInventory = intval($_POST['inventory']);
    $stmt = $pdo->prepare("UPDATE Products SET Inventory = ? WHERE ProductID = ?");
    $stmt->execute([$newInventory, $productId]);

    header('Location: products.php'); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Edit Product</h1>
        <form method="POST">
            <label for="inventory">Inventory:</label>
            <input type="number" name="inventory" id="inventory" value="<?php echo htmlspecialchars($product['Inventory']); ?>" required>
            <button type="submit">Update Inventory</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
