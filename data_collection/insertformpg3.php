<?php
session_start();

// Establish database connection securely
$conn = new mysqli('localhost', 'root', '', 'userdata');
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Could not connect to the database. Please try again later.");
}

// Validate session data
if (isset($_SESSION['first_name'], $_SESSION['surname'], $_SESSION['email'], $_SESSION['address0'])) {
    $name = $_SESSION['first_name'];
    $surname = $_SESSION['surname'];
    $email = $_SESSION['email'];
    $address0 = $_SESSION['address0'];

    // Check for duplicates
    $checkQuery = "SELECT id FROM users WHERE first_name = ? AND surname = ? AND email = ? AND address0 = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('ssss', $name, $surname, $email, $address0);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // Insert user data
        $insertQuery = "INSERT INTO users (first_name, surname, email, address0) VALUES (?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param('ssss', $name, $surname, $email, $address0);

        if ($insertStmt->execute()) {
            echo "User data inserted successfully!";
        } else {
            error_log("Insertion error: " . $insertStmt->error);
            echo "An error occurred while saving your data.";
        }
        $insertStmt->close();
    } else {
        echo "This user data already exists in our database.";
    }
    $stmt->close();
} else {
    echo "Missing required session data. Please complete all steps.";
}

// Close connection
$conn->close();
?>
