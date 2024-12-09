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