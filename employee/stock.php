<?php
session_start();
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = sanitizeInput($_POST['product_id']);
    $quantity = sanitizeInput($_POST['quantity']);

    $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
    $stmt->execute([$quantity, $productId]);

    echo "Stock updated successfully.";
}
?>

<h2>Update Stock</h2>
<form method="POST">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <input type="number" name="quantity" placeholder="Quantity" required>
    <button type="submit">Update Stock</button>
</form>
