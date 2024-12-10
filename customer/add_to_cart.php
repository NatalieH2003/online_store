<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = sanitizeInput($_GET['product_id']);
    $userId = $_SESSION['user_id'];
    $quantity = 1; // Default quantity to add

    // Check stock
    $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if (!$product) {
        echo "Error: Product does not exist.";
        redirect('browse.php');
        exit;
    }

    if ($product['stock'] <= 0) {
        echo "Error: Product is out of stock.";
        redirect('browse.php');
        exit;
    }

    // Check if the product already exists in the cart
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $cartItem = $stmt->fetch();

    if ($cartItem) {
        // Update quantity if stock allows
        if ($product['stock'] >= $cartItem['quantity'] + 1) {
            $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $stmt->execute([$userId, $productId]);
            echo "Item quantity updated successfully.";
        } else {
            echo "Error: Insufficient stock to add more.";
        }
    } else {
        // Add new item to the cart
        $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $productId, $quantity]);
        echo "Item added to cart successfully.";
    }

    redirect('cart.php');
}
?>
