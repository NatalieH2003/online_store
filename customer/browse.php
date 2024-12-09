<?php
include '../db.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

echo "<h1>Browse Products</h1>";
echo "<form method='GET'>";
echo "<select name='category'>";
foreach ($categories as $category) {
    echo "<option value='{$category['id']}'>{$category['name']}</option>";
}
echo "</select>";
echo "<button type='submit'>Search</button>";
echo "</form>";

if (isset($_GET['category'])) {
    $categoryId = $_GET['category'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->execute([$categoryId]);
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        echo "<p>{$product['name']} - {$product['price']} <a href='add_to_cart.php?product_id={$product['id']}'>Add to Cart</a></p>";
    }
}
?>