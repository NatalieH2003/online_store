<<<<<<< HEAD
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin(); // Ensure the employee is logged in

echo "<h1>Welcome to the Employee Dashboard</h1>";
echo "<p>Hello, Employee! Here are your management options:</p>";

echo "<ul>";
echo "<li><a href='stock.php'>Update Stock Levels</a></li>";
echo "<li><a href='price.php'>Update Product Prices</a></li>";
echo "<li><a href='history.php'>View Product History</a></li>";
echo "<li><a href='../logout.php'>Logout</a></li>";
echo "</ul>";
?>
=======
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin(); // Ensure the employee is logged in

echo "<h1>Welcome to the Employee Dashboard</h1>";
echo "<p>Hello, Employee! Here are your management options:</p>";

echo "<ul>";
echo "<li><a href='stock.php'>Update Stock Levels</a></li>";
echo "<li><a href='price.php'>Update Product Prices</a></li>";
echo "<li><a href='history.php'>View Product History</a></li>";
echo "<li><a href='../logout.php'>Logout</a></li>";
echo "</ul>";
?>
>>>>>>> 3e11ed5309f87f7f6f7b338b12fb6fc8fd62bd7b
