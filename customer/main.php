
<?php
session_start();
include '../db.php';
include '../common.php';

checkLogin();

?>

<h1>Welcome to the Customer Dashboard</h1><br>
<a href='browse.php'>Browse Products</a><br>
<a href='cart.php'>View Shopping Cart</a><br>
<a href='orders.php'>View Orders</a><br>
<a href='../logout.php'>Logout</a><br>
<a href='reset_password.php'> Reset Password</a><br>
