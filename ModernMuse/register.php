<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $middleInitial = $_POST['middle_initial'] ?: null;
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];


    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[\W]/', $password)) {
        $errors[] = "Password must be at least 8 characters long, contain at least one capital letter and one symbol.";
    }
    if (!preg_match('/^\d{10}$/', $phone)) {
        $errors[] = "Phone number must contain exactly 10 digits.";
    }
    if (strlen($username) < 5 || strlen($username) > 15) {
        $errors[] = "Username must be between 5 and 15 characters.";
    }

    $stmt = $pdo->prepare("SELECT * FROM Customers WHERE Email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $errors[] = "Email already registered.";
    }

    // If no errors, register user
    if (empty($errors)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO Customers (FirstName, LastName, MiddleInitial, Email, PhoneNumber, Username, PasswordHash) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$firstName, $lastName, $middleInitial, $email, $phone, $username, $passwordHash]);
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Modern Muse</title>
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

        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Register</h1>
        <?php if (!empty($errors)): ?>
            <div class="error"><?php echo implode('<br>', $errors); ?></div>
        <?php endif; ?>
        <form method="POST" onsubmit="return validateForm()">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="middle_initial" placeholder="Middle Initial">
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required maxlength="10" pattern="\d{10}">
            <input type="text" name="username" placeholder="Username" required maxlength="15">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </main>
    <footer>
        <p>&copy; 2024 Modern Muse</p>
    </footer>

    <script>
        function validateForm() {

            const errors = document.querySelectorAll('.error');
            const submitButton = document.querySelector('button[type="submit"]');
            if (errors.length > 0) {
                submitButton.disabled = true; // Disable button if errors exist
                return false; 
            }
            return true; 
        }
    </script>
</body>
</html>
