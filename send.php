<?php
ob_start(); // Start output buffering at the top of the file (prevents header errors)

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "heartinjapan";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into the contact table
    $sql = "INSERT INTO contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to thank you page
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
ob_end_flush(); // End output buffering
?>
