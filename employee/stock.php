<?php
session_start();
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = sanitizeInput($_POST['product_id']);
    $quantity = sanitizeInput($_POST['quantity']);

    $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
    $stmt->execute([$quantity, $productId]);

    $stmt = $pdo->prepare("insert into stock_history (product_id, change_amount, change_date) values (?, ?, CURRENT_TIMESTAMP())");
    $stmt->execute([$productId, $quantity]); 


    echo "Stock updated successfully.";
}
?>

<h2>Update Stock</h2>
<form method="POST">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <button type="submit">Update Stock</button>
</form>

