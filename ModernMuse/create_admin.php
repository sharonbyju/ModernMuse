<?php
session_start();
include 'db.php'; 

$email = 'admin1@modernmuse.com';
$username = 'adminUser1';
$password = 'YourAdminPassword123!'; 
$firstName = 'Admin';
$lastName = 'User';
$phoneNumber = '1234567890'; 
$role = 'admin';

$stmt = $pdo->prepare("SELECT * FROM Customers WHERE Email = ?");
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    echo "Admin user already exists.";
} else {
    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new admin user into the database
    $sql = "INSERT INTO Customers (FirstName, LastName, Email, PhoneNumber, Username, PasswordHash, Role) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$firstName, $lastName, $email, $phoneNumber, $username, $passwordHash, $role]);

    echo "Admin user created successfully.";
}
?>
