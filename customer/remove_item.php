<<<<<<< HEAD
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['item_id'])) {
    $itemId = sanitizeInput($_GET['item_id']);
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$itemId, $userId]);

    echo "Item removed from cart.";
    redirect('cart.php');
}
?>
=======
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['item_id'])) {
    $itemId = sanitizeInput($_GET['item_id']);
    $userId = $_SESSION['user_id'];

    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$itemId, $userId]);

    echo "Item removed from cart.";
    redirect('cart.php');
}
?>
>>>>>>> 3e11ed5309f87f7f6f7b338b12fb6fc8fd62bd7b
