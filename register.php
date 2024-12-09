<?php
include 'db.php'; // Include database connection
include 'common.php'; // Include common helper functions

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate inputs
    if (empty($username) || empty($password) || empty($confirmPassword)) {
        echo "<p>All fields are required.</p>";
    } elseif ($password !== $confirmPassword) {
        echo "<p>Passwords do not match.</p>";
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT * FROM customers WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetch()) {
                echo "<p>Username already exists. Please choose another.</p>";
            } else {
                // Insert new user into the database
                $stmt = $pdo->prepare("INSERT INTO customers (username, password) VALUES (?, ?)");
                $stmt->execute([$username, $hashedPassword]);

                echo "<p>Registration successful! <a href='login.php'>Login here</a></p>";
                exit;
            }
        } catch (Exception $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        /* Basic styling for simplicity */
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
        <h2>Register</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
