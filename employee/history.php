<?php
// Include database connection and common functions
include '../db.php'; // Ensure this file sets up a valid $pdo connection
include '../common.php'; // Ensure sanitizeInput is defined here

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $productId = sanitizeInput($_GET['product_id']);

    try {
        // Fetch stock history
        echo "<h2>Stock History</h2>";
        $stmt = $pdo->prepare("SELECT change_date, change_amount FROM stock_history WHERE product_id = ?");
        $stmt->execute([$productId]);

        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $record) {
                echo "<p>Date: {$record['change_date']}, Change: {$record['change_amount']}</p>";
            }
        } else {
            echo "<p>No stock history found for Product ID: $productId</p>";
        }

        // Fetch price history
        echo "<h2>Price History</h2>";
        $stmt = $pdo->prepare("SELECT change_date, old_price, new_price FROM price_history WHERE product_id = ?");
        $stmt->execute([$productId]);

        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $record) {
                echo "<p>Date: {$record['change_date']}, Old Price: {$record['old_price']}, New Price: {$record['new_price']}</p>";
            }
        } else {
            echo "<p>No price history found for Product ID: $productId</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}
?>

<h2>View History</h2>
<form method="GET">
    <input type="number" name="product_id" placeholder="Product ID" required>
    <button type="submit">View History</button>
</form>
