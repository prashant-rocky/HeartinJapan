<?php
header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$username = "root";   // change if needed
$password = "";       // change if needed
$dbname = "heartinjapan";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare insert query
        $stmt = $conn->prepare("INSERT INTO subscribe (email) VALUES (?)");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => '🎉 Thank you for subscribing!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address.']);
    }
}

$conn->close();
?>
