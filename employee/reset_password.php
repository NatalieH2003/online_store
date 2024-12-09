<?php
session_start();
include '../db.php';
include '../common.php';

if (!isset($_SESSION['employee_id'])) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $employeeId = $_SESSION['employee_id'];

    // Update password and set first_login to 0
    $stmt = $pdo->prepare("UPDATE employees SET password = ?, first_login = 0 WHERE id = ?");
    $stmt->execute([$newPassword, $employeeId]);

    echo "<p>Password reset successfully!</p>";
    redirect('main.php');
}
?>

<h2>Reset Password</h2>
<form method="POST">
    <input type="password" name="new_password" placeholder="New Password" required>
    <button type="submit">Reset Password</button>
</form>
