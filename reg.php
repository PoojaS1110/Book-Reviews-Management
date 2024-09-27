<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <style>
        body {
            background-color: #f2f2f2;
            color: #333333;
            font-family: 'Arial', sans-serif;
        }

        form {
            width: 50%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"],
        input[type="button"] {
            padding: 10px;
            background-color: #ddd; 
            color: #333333;
            cursor: pointer;
            border: none;
            border-radius: 3px;
            margin-right: 5px;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #ccc; /* Lighter shade on hover */
        }
    </style>
</head>
<body>
    <h1>Registration Page</h1>

    <?php
    // Check if the registration form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve user details from the form
        $username = $_POST['username'];
        $email = $_POST['email'];
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

        // Insert user details into the 'users' table
        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        if ($conn->query($query) === TRUE) {
            echo '<p>Registration successful! User details added to the database.</p>';
        } else {
            echo 'Error: ' . $query . '<br>' . $conn->error;
        }

        // Close database connection
        $conn->close();
    }
    ?>

    <!-- Registration Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" value="Register">
        <input type="button" value="Login" onclick="redirectToLoginPage()">
    </form>

    <script>
        function redirectToLoginPage() {
            window.location.href = 'http://localhost/bookstore/login.php';
        }
    </script>
</body>
</html>
