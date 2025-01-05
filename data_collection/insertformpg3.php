<?php
session_start();

// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'userdata');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if all session data is set before inserting into the database
if (
    isset($_SESSION['first_name']) &&
    isset($_SESSION['surname']) &&
    isset($_SESSION['personal_email']) &&
    isset($_SESSION['address'])
) {
    // Use prepared statements to prevent SQL injection
    $name = $_SESSION['first_name'];
    $surname = $_SESSION['surname'];
    $email = $_SESSION['personal_email'];
    $address = $_SESSION['address'];

    // Check if the user data already exists to avoid duplicate entries
    $checkQuery = "SELECT id FROM users WHERE first_name = ? AND surname = ? AND email = ? AND address = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('ssss', $name, $surname, $email, $address);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Insert the user data into the database
        $insertQuery = "INSERT INTO users (first_name, surname, email, address) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('ssss', $name, $surname, $email, $address);

        if ($insertStmt->execute()) {
            echo "User data inserted successfully!";
        } else {
            echo "Error: " . $insertStmt->error;
        }

        $insertStmt->close();
    } else {
        echo "User data already exists. Skipping insertion.";
    }

    $stmt->close();
} else {
    echo "Incomplete session data. Cannot insert user.";
}

// Close the connection
$conn->close();
?>
