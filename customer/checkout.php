<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];

try {
    $pdo->beginTransaction();

    // Get cart items
    $stmt = $pdo->prepare("
        SELECT cart.product_id, cart.quantity, products.stock
        FROM cart
        INNER JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($cartItems)) {
        echo "Your cart is empty.";
        $pdo->rollBack();
        redirect('cart.php');
        exit;
    }

    // Create a new order
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, order_date) VALUES (?, NOW())");
    $stmt->execute([$userId]);
    $orderId = $pdo->lastInsertId();

    foreach ($cartItems as $item) {
        $productId = $item['product_id'];
        $quantity = $item['quantity'];
        $stock = $item['stock'];

        // Check stock
        if ($stock < $quantity) {
            echo "Error: Insufficient stock for product ID: $productId.";
            $pdo->rollBack();
            redirect('cart.php');
            exit;
        }

        // Deduct stock
        $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);

        // Insert into order_items
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                               SELECT ?, id, ?, price FROM products WHERE id = ?");
        $stmt->execute([$orderId, $quantity, $productId]);

        // Insert into stock_history
        $stmt = $pdo->prepare("INSERT INTO stock_history (product_id, change_amount, change_date) VALUES (?, ?, NOW())");
        $stmt->execute([$productId, -$quantity]);
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
