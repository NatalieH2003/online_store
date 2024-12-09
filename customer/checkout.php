<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];

try {
    $pdo->beginTransaction();

    // Get cart items
    $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();

    if (empty($cartItems)) {
        echo "Your cart is empty.";
        $pdo->rollBack();
        redirect('cart.php');
    }

    // Create new order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, NOW())");
    $stmt->execute([$userId]);
    $orderId = $pdo->lastInsertId();

    // Add items to order and check stock
    foreach ($cartItems as $item) {
        $productId = $item['product_id'];
        $quantity = $item['quantity'];

        // Check stock
        $stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch();

        if ($product['stock'] < $quantity) {
            echo "Insufficient stock for product ID: $productId.";
            $pdo->rollBack();
            redirect('cart.php');
        }

        // Deduct stock
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);

        // Add item to order
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$orderId, $productId, $quantity]);
    }

    // Clear cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);

    $pdo->commit();
    echo "Checkout successful. Your order number is: $orderId";
    redirect('orders.php');
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Error during checkout: " . $e->getMessage();
}
?>
