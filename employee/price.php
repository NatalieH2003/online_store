<?php
session_start();
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = sanitizeInput($_POST['product_id']);
    $newPrice = sanitizeInput($_POST['price']);

    $stmt = $pdo->prepare("select price from products where id = ?");
    $stmt->execute([$productId]);
    $old_price = $stmt->fetch();

    // Update price
    $stmt = $pdo->prepare("UPDATE products SET price = ? WHERE id = ?");
    $stmt->execute([$newPrice, $productId]);

    $stmt = $pdo->prepare("insert into price_history (product_id, old_price, new_price, change_date) values (?, ?, ?, CURRENT_TIMESTAMP())");
    $stmt->execute([$productId, $old_price, $newPrice]);

    echo "Price updated successfully.";
}

?>

<h2>Update Price</h2>
<form method="POST">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <input type="number" name="price" placeholder="New Price" step="0.01" required>
    <button type="submit">Update Price</button>
</form>
