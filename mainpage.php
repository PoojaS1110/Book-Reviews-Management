<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Reads</title>
    <style>
        body {
            background-color: #f5f5f5; /* Lighter grey background */
            color: #333333; /* Dark grey text */
            font-family: 'Arial', sans-serif;
        }

        #user-profile {
            display: flex;
            flex-direction: row; /* Align items horizontally */
            justify-content: space-between; /* Distribute space between items */
            align-items: center;
            background-color: #e0e0e0; /* Light grey background */
            padding: 10px;
            margin-bottom: 20px; /* Add margin for separation */
        }

        #user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-bottom: 10px; /* Add margin between image and text */
        }

        #user-info {
            text-align: center;
        }

        #user-info span {
            display: block; /* Each info on a new line */
            margin-bottom: 5px; /* Add margin between lines */
        }

        #view-users-button {
            padding: 5px;
            background-color: #333333; /* Dark grey background */
            color: #f2f2f2; /* Light grey text */
            cursor: pointer;
            border: none;
            border-radius: 3px;
        }

        .auth-buttons {
            display: flex;
            gap: 10px; /* Add gap between buttons */
        }

        #register-button,
        #login-button {
            padding: 5px;
            background-color: #333333; /* Dark grey background */
            color: #f2f2f2; /* Light grey text */
            cursor: pointer;
            border: none;
            border-radius: 3px;
        }

        h1 {
            color: #333333; /* Dark grey text */
            text-align: center;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #e0e0e0; /* Light grey background */
            color: #333333; /* Dark grey text */
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        form {
            margin-top: 10px;
        }

        input[type="text"] {
            padding: 5px;
        }

        button {
            padding: 5px;
            background-color: #333333; /* Dark grey background */
            color: #f2f2f2; /* Light grey text */
            cursor: pointer;
            border: none;
            border-radius: 3px;
            margin-right: 5px;
        }

        .reviews {
            margin-top: 10px;
        }

        .more-reviews {
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1>Book Reads</h1>

    <div id="user-profile">
        <div class="auth-buttons">
            <button id="register-button" onclick="redirectToRegisterPage()">Register</button>
            <button id="login-button" onclick="redirectToLoginPage()">Login</button>
        </div>

        <div id="user-info">
            <img src="OIP.JPG" alt="User Icon">
            <span>Username: Pooja S</span>
            <span>ID: 21ETCS002103</span>
        </div>

        <button id="view-users-button" onclick="redirectToUsersPage()">View Users</button>
    </div>

    <!-- Search Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
        <label for="bookName">Search by Title:</label>
        <input type="text" id="bookName" name="bookName" placeholder="Enter book title">
        <input type="submit" value="Search">
    </form>

    <ul>
        <?php

        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'books.db';

        // Connect to MySQL
        $conn = new mysqli($hostname, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle Search
        if (isset($_GET['bookName'])) {
            $bookName = $_GET['bookName'];
            $query = "SELECT title, author, review, new_review FROM books WHERE title LIKE '%$bookName%'";
        } else {
            // Fetch all books if no search input
            $query = "SELECT title, author, review, new_review FROM books";
        }

        // Execute Query
        $result = $conn->query($query);

        // Check for errors
        if (!$result) {
            die("Error in query: " . $conn->error);
        }

        // Display books and review forms
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>{$row['title']}</strong> by {$row['author']}<br>Review: {$row['review']}";

            // Display More Reviews
            if (!empty($row['new_review'])) {
                echo "<div class='more-reviews'>More Reviews: {$row['new_review']}</div>";
            }

            echo "</li>";

            echo "<form method='post' action=''>";
            echo "<input type='hidden' name='title' value='{$row['title']}'>";
            echo "<input type='text' name='newReview' placeholder='Add a new review'>";
            echo "<button type='submit' name='addReview'>Add Review</button>";
            echo "<input type='text' name='updatedReview' placeholder='Update the review'>";
            echo "<button type='submit' name='updateReview'>Update Review</button>";
            echo "<button type='submit' name='deleteReview'>Delete Review</button>";
            echo "</form>";
        }

        // Handle adding a new review or deleting a review
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];

            if (isset($_POST['addReview'])) {
                $newReview = $_POST['newReview'];

                // Add the new review to the 'new_review' column
                $conn->query("UPDATE books SET new_review = '$newReview' WHERE title = '$title'");
            } elseif (isset($_POST['updateReview'])) {
                $updatedReview = $_POST['updatedReview'];

                // Update the 'review' column
                $conn->query("UPDATE books SET review = '$updatedReview' WHERE title = '$title'");
            } elseif (isset($_POST['deleteReview'])) {
                // Delete the 'review' column
                $conn->query("UPDATE books SET review = NULL WHERE title = '$title'");
            }
        }

        // Close database connection
        $conn->close();

        ?>
    </ul>

    <script>
        function redirectToRegisterPage() {
            window.location.href = 'http://localhost/bookstore/reg.php';
        }

        function redirectToLoginPage() {
            window.location.href = 'http://localhost/bookstore/login.php';
        }

        function redirectToUsersPage() {
            window.location.href = 'http://localhost/bookstore/users.php';
        }
    </script>
</body>
</html>
