<?php
// Include the database connection and common helper functions
include '../db.php';
include '../common.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent SQL injection
    $name = sanitizeInput($_POST['name']);
    $username = sanitizeInput($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

    try {
        // Insert the new employee into the database
        $stmt = $pdo->prepare("
            INSERT INTO employees (name, username, password, first_login) 
            VALUES (?, ?, ?, 1)
        ");
        $stmt->execute([$name, $username, $password]);

        // Registration success message
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } catch (PDOException $e) {
        // Check for duplicate username error
        if ($e->getCode() === '23000') { // SQLSTATE 23000: Integrity constraint violation
            echo "<p>Username already exists. Please choose a different one.</p>";
        } else {
            // General error message
            echo "<p>An error occurred while registering. Please try again later.</p>";
        }
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        <h2>Employee Registration</h2>
        <form method="POST">
            <input type="text" name="name" placeholder="Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
