<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];

echo "<h1>Your Orders</h1>";

// Fetch orders with total item count
$stmt = $pdo->prepare("
    SELECT orders.id, orders.order_date, 
           COALESCE(SUM(order_items.quantity), 0) AS total_items
    FROM orders
    LEFT JOIN order_items ON orders.id = order_items.order_id
    WHERE orders.user_id = ?
    GROUP BY orders.id
    ORDER BY orders.order_date DESC
");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($orders)) {
    foreach ($orders as $order) {
        echo "<h3>Order ID: {$order['id']} - Date: {$order['order_date']}</h3>";
        echo "<p>Total Items: {$order['total_items']}</p>";

        // Fetch order items
        $stmt = $pdo->prepare("
            SELECT order_items.product_id, order_items.quantity, products.name, order_items.price
            FROM order_items
            INNER JOIN products ON order_items.product_id = products.id
            WHERE order_items.order_id = ?
        ");
        $stmt->execute([$order['id']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<ul>";
        foreach ($items as $item) {
            echo "<li>Product: {$item['name']} - Quantity: {$item['quantity']} - Price: $" . number_format($item['price'], 2) . "</li>";
        }
        echo "</ul>";
    }
} else {
    echo "<p>You have no orders yet.</p>";
}
?>
