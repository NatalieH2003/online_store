<?php
$host = 'localhost'; // phpMyAdmin typically runs on localhost
$user = 'root';      // Default username for phpMyAdmin
$password = '';      // Default password for phpMyAdmin (leave blank for XAMPP)
$dbname = 'online_store'; // Your database name

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
