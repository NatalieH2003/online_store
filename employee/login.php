<<<<<<< HEAD
<?php
session_start();
include '../db.php'; // Include database connection
include '../common.php'; // Include common helper functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    // Check if the employee exists
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE username = ?");
    $stmt->execute([$username]);
    $employee = $stmt->fetch();

    if ($employee && password_verify($password, $employee['password'])) {
        // Check if it's the first login
        if ($employee['first_login'] == 1) {
            $_SESSION['employee_id'] = $employee['id'];
            header("Location: reset_password.php");
            exit;
        } else {
            // Successful login
            $_SESSION['employee_id'] = $employee['id'];
            $_SESSION['employee_name'] = $employee['name'];
            header("Location: main.php");
            exit;
        }
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        form input, form button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Employee Login</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
=======
<?php
session_start();
include '../db.php';
include '../common.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Fetch employee details
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE email = ?");
    $stmt->execute([$email]);
    $employee = $stmt->fetch();

    if ($employee && password_verify($password, $employee['password'])) {
        // Check if it's the first login
        if ($employee['first_login'] == 1) {
            $_SESSION['employee_id'] = $employee['id'];
            redirect('reset_password.php');
        } else {
            $_SESSION['employee_id'] = $employee['id'];
            redirect('main.php');
        }
    } else {
        echo "<p>Invalid login credentials.</p>";
    }
}
?>

<h2>Employee Login</h2>
<form method="POST">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
>>>>>>> 3e11ed5309f87f7f6f7b338b12fb6fc8fd62bd7b
