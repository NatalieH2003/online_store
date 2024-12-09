<<<<<<< HEAD
<?php
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = sanitizeInput($_GET['product_id']);

    // Fetch stock history
    echo "<h2>Stock History</h2>";
    $stmt = $pdo->prepare("SELECT * FROM stock_history WHERE product_id = ?");
    $stmt->execute([$productId]);
    foreach ($stmt->fetchAll() as $record) {
        echo "<p>Date: {$record['date']}, Change: {$record['change']}</p>";
    }

    // Fetch price history
    echo "<h2>Price History</h2>";
    $stmt = $pdo->prepare("SELECT * FROM price_history WHERE product_id = ?");
    $stmt->execute([$productId]);
    foreach ($stmt->fetchAll() as $record) {
        echo "<p>Date: {$record['date']}, New Price: {$record['new_price']}</p>";
    }
}
?>

<h2>View History</h2>
<form method="GET">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <button type="submit">View History</button>
</form>
=======
<?php
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = sanitizeInput($_GET['product_id']);

    // Fetch stock history
    echo "<h2>Stock History</h2>";
    $stmt = $pdo->prepare("SELECT * FROM stock_history WHERE product_id = ?");
    $stmt->execute([$productId]);
    foreach ($stmt->fetchAll() as $record) {
        echo "<p>Date: {$record['date']}, Change: {$record['change']}</p>";
    }

    // Fetch price history
    echo "<h2>Price History</h2>";
    $stmt = $pdo->prepare("SELECT * FROM price_history WHERE product_id = ?");
    $stmt->execute([$productId]);
    foreach ($stmt->fetchAll() as $record) {
        echo "<p>Date: {$record['date']}, New Price: {$record['new_price']}</p>";
    }
}
?>

<h2>View History</h2>
<form method="GET">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <button type="submit">View History</button>
</form>
>>>>>>> 3e11ed5309f87f7f6f7b338b12fb6fc8fd62bd7b
