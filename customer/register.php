<?php
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO customers (username, password) VALUES (?, ?)");
    $stmt->execute([$name, $password]);

    echo "Registration successful! <a href='login.php'>Login here</a>";
    exit;
}
?>

<h2>Register</h2>
<form method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

