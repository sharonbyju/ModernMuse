<?php
session_start();
include 'db.php';

$error = ''; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {

        $stmt = $pdo->prepare("SELECT * FROM Customers WHERE Email = ?");
        $stmt->execute([$_POST['email']]);
        $user = $stmt->fetch();

        if ($user && password_verify($_POST['password'], $user['PasswordHash'])) {
            $_SESSION['customer_id'] = $user['CustomerID']; 
            $_SESSION['username'] = $user['Username']; 

            if ($user['Role'] === 'admin') { 
                $_SESSION['is_admin'] = true;
            }

            header('Location: products.php'); 
            exit();
        } else {
            $error = "Email not registered or incorrect password.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Modern Muse</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #ede8de;
            font-family: Arial, sans-serif;
        }
        main {
            max-width: 800px; 
            margin: 40px auto; 
            padding: 20px;
            background-color: #d2d4c9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c2c2c;
        }
        input {
            width: calc(100% - 22px); 
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #79918b;
            border-radius: 5px;
        }
        input:focus {
            border-color: #907182;
            outline: none;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #79918b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #907182;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Login</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>
</body>
</html>
