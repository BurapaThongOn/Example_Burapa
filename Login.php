<?php
// Establish connection to your database (MySQL example)
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to retrieve user data
    $sql = "SELECT * FROM users WHERE username='$username'";

    // Execute query
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, redirect to success page
            header("Location: success.php");
            exit();
        } else {
            // Password is incorrect, redirect back to login page with error message
            header("Location: login.html?error=invalid");
            exit();
        }
    } else {
        // Username not found, redirect back to login page with error message
        header("Location: login.html?error=invalid");
        exit();
    }
}

// Close connection
$conn->close();
?>
