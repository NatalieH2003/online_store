
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

$userId = $_SESSION['user_id'];

// Handle quantity update if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'], $_POST['quantity'])) {
    $itemId = sanitizeInput($_POST['item_id']);
    $newQuantity = (int)sanitizeInput($_POST['quantity']);

    if ($newQuantity > 0) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$newQuantity, $itemId, $userId]);
        echo "<p>Quantity updated successfully.</p>";
    } else {
        echo "<p>Invalid quantity. Please enter a number greater than 0.</p>";
    }
}

// Fetch cart items along with product details
$cartItems = $pdo->prepare("
    SELECT cart.id, cart.quantity, products.name AS product_name, products.price
    FROM cart
    INNER JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$cartItems->execute([$userId]);

echo "<h1>Your Shopping Cart</h1>";

$items = $cartItems->fetchAll(PDO::FETCH_ASSOC);

if (!empty($items)) {
    foreach ($items as $item) {
        echo "<form method='POST' action='cart.php'>";
        echo "<p>Product Name: " . htmlspecialchars($item['product_name']) . "</p>";
        echo "<p>Price: $" . number_format($item['price'], 2) . "</p>";
        echo "<p>Quantity: <input type='number' name='quantity' value='" . htmlspecialchars($item['quantity']) . "' min='1'></p>";
        echo "<input type='hidden' name='item_id' value='" . htmlspecialchars($item['id']) . "'>";
        echo "<button type='submit'>Update Quantity</button>";
        echo "</form>";
        echo "<a href='remove_item.php?item_id={$item['id']}'>Remove</a>";
        echo "<hr>";
    }
    echo "<a href='checkout.php'>Checkout</a>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>
