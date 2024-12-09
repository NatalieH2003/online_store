<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];
$cartItems = $pdo->prepare("SELECT * FROM cart WHERE user_id = ?");
$cartItems->execute([$userId]);

echo "<h1>Your Shopping Cart</h1>";
foreach ($cartItems->fetchAll() as $item) {
    echo "<p>{$item['product_name']} - {$item['quantity']} - {$item['price']} <a href='remove_item.php?item_id={$item['id']}'>Remove</a></p>";
}

echo "<a href='checkout.php'>Checkout</a>";
?>
