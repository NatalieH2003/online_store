<?php
session_start();
include '../db.php';
include '../common.php';

// Redirect to login page if the session is not set
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch employee details if needed
$employeeName = htmlspecialchars($_SESSION['employee_name']); // Escape output for safety
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1, ul {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin: 10px 0;
        }
        ul li a {
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        ul li a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?= $employeeName ?>!</h1>
        <p>Here are your management options:</p>
        <ul>
            <li><a href="stock.php">Restock Product</a></li>
            <li><a href="price.php">Change Product Price</a></li>
            <li><a href="stock.php">Stock</a></li>
            <li><a href="history.php">Price History</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</body>
</html>
