<<<<<<< HEAD
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = sanitizeInput($_GET['product_id']);
    $userId = $_SESSION['user_id'];
    $quantity = 1; // Default quantity to add

    // Check if product already in cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $cartItem = $stmt->fetch();

    if ($cartItem) {
        // Update quantity
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
    } else {
        // Insert new item into cart
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $productId, $quantity]);
    }

    echo "Item added to cart successfully.";
    redirect('cart.php');
}
?>
=======
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = sanitizeInput($_GET['product_id']);
    $userId = $_SESSION['user_id'];
    $quantity = 1; // Default quantity to add

    // Check if product already in cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $cartItem = $stmt->fetch();

    if ($cartItem) {
        // Update quantity
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
    } else {
        // Insert new item into cart
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $productId, $quantity]);
    }

    echo "Item added to cart successfully.";
    redirect('cart.php');
}
?>
>>>>>>> 3e11ed5309f87f7f6f7b338b12fb6fc8fd62bd7b
