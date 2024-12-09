<<<<<<< HEAD
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];

echo "<h1>Your Orders</h1>";

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll();

foreach ($orders as $order) {
    echo "<h3>Order ID: {$order['id']} - Date: {$order['order_date']}</h3>";

    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$order['id']]);
    $items = $stmt->fetchAll();

    foreach ($items as $item) {
        echo "<p>Product ID: {$item['product_id']}, Quantity: {$item['quantity']}</p>";
    }
}
?>
=======
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];

echo "<h1>Your Orders</h1>";

$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll();

foreach ($orders as $order) {
    echo "<h3>Order ID: {$order['id']} - Date: {$order['order_date']}</h3>";

    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $stmt->execute([$order['id']]);
    $items = $stmt->fetchAll();

    foreach ($items as $item) {
        echo "<p>Product ID: {$item['product_id']}, Quantity: {$item['quantity']}</p>";
    }
}
?>
>>>>>>> 3e11ed5309f87f7f6f7b338b12fb6fc8fd62bd7b
