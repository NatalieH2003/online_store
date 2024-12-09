<?php
session_start();
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Fetch employee details
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE email = ?");
    $stmt->execute([$email]);
    $employee = $stmt->fetch();

    if ($employee && password_verify($password, $employee['password'])) {
        // Check if it's the first login
        if ($employee['first_login'] == 1) {
            $_SESSION['employee_id'] = $employee['id'];
            redirect('reset_password.php');
        } else {
            $_SESSION['employee_id'] = $employee['id'];
            redirect('main.php');
        }
    } else {
        echo "<p>Invalid login credentials.</p>";
    }
}
?>

<h2>Employee Login</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
