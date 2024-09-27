<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            color: #333333;
            text-align: center;
            margin-bottom: 20px; /* Added margin bottom to create space between title and table */
        }

        table {
            width: 60%;
            margin: 0 auto; /* Center the table horizontally */
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #333333;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .delete-btn {
            background-color: #cccccc;
            color: #333333;
            border: none;
            padding: 5px 8px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>List of Registered Users</h1> 

    <?php
    // Connect to MySQL
    $conn = new mysqli('localhost', 'root', '', 'usersdb');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle delete action
    if(isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $delete_query = "DELETE FROM users WHERE id = $delete_id";
        if($conn->query($delete_query) === TRUE) {
            echo "<p>done.</p>";
        } else {
            echo "<p>Error deleting user: " . $conn->error . "</p>";
        }
    }

    // Fetch users from the database
    $query = "SELECT * FROM users";
    $result = $conn->query($query);

    // Display user details
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['email']}</td><td><form method='post'><input type='hidden' name='delete_id' value='{$row['id']}'><button class='delete-btn' type='submit'>Delete</button></form></td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No registered users.</p>";
    }

    // Close database connection
    $conn->close();
    ?>
</body>
</html>
