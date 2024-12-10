<?php
include '../db.php';

// Define the sanitizeInput function
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

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
    $categoryId = sanitizeInput($_GET['category']);
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
    $stmt->execute([$categoryId]);
    $products = $stmt->fetchAll();

    foreach ($products as $product) {
        $productName = htmlspecialchars($product['name']);
        $productPrice = htmlspecialchars($product['price']);
        $productId = htmlspecialchars($product['id']);
        $productStock = (int)$product['stock'];

        echo "<p>";
        echo "Product: $productName - Price: \$$productPrice - Stock: $productStock ";

        if ($productStock > 0) {
            echo "<a href='add_to_cart.php?product_id=$productId'>Add to Cart</a>";
        } else {
            echo "<span style='color: red;'>Out of Stock</span>";
        }

	echo "({$productId})";

        echo "</p>";
    }
} else {
    echo "<p>Please select a category to view products.</p>";
}
?>
