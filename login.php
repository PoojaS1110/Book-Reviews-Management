<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            background-color: #ecf0f1;
            color: #333333;
            font-family: 'Arial', sans-serif;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"],
        .register-button {
            padding: 10px;
            background-color: #3498db; /* Blue color */
            color: #ffffff;
            cursor: pointer;
            border: none;
            border-radius: 3px;
        }

        input[type="submit"]:hover,
        .register-button:hover {
            background-color: #2980b9; 
        }
    </style>
</head>
<body>
    <h1>Login Page</h1>

    <?php
    // login form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve user credentials from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Connect to MySQL
        $hostname = 'localhost';
        $db_username = 'root';
        $db_password = '';
        $database = 'usersdb';

        $conn = new mysqli($hostname, $db_username, $db_password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check user credentials
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            header("Location: http://localhost/bookstore/poo.php");
            exit();
        } else {
            echo '<p>Invalid credentials. Please register to continue.</p>';
            echo '<a class="register-button" href="http://localhost/bookstore/reg.php">Register</a>';
        }

        // Close database connection
        $conn->close();
    }
    ?>

    <!-- Login Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Login">
    </form>
</body>
</html>
