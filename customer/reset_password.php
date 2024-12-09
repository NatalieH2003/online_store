<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $user_id = $_SESSION['user_id'];

    // Update password and set first_login to 0
    $stmt = $pdo->prepare("UPDATE customers SET password = ? WHERE id = ?");
    $stmt->execute([$newPassword, $user_id]);

    echo "<p>Password reset successfully!</p>";
    redirect('main.php');
}
?>

<h2>Reset Password</h2>
<form method="POST">
    <input type="password" name="new_password" placeholder="New Password" required>
    <button type="submit">Reset Password</button>
</form>
