<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

echo "<h1>Welcome to the Customer Dashboard</h1>";
echo "<a href='browse.php'>Browse Products</a><br>";
echo "<a href='cart.php'>View Shopping Cart</a><br>";
echo "<a href='orders.php'>View Orders</a><br>";
echo "<a href='../logout.php'>Logout</a>";
?>
