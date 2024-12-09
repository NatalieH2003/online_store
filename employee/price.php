<?php
session_start();
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = sanitizeInput($_POST['product_id']);
    $newPrice = sanitizeInput($_POST['price']);

    // Update price
    $stmt = $pdo->prepare("UPDATE products SET price = ? WHERE id = ?");
    $stmt->execute([$newPrice, $productId]);

    echo "Price updated successfully.";
}

?>

<h2>Update Price</h2>
<form method="POST">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <input type="number" name="price" placeholder="New Price" step="0.01" required>
    <button type="submit">Update Price</button>
</form>
