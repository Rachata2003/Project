<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'userdata');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve session data
$first_name = $_SESSION['first_name'] ?? "Not provided";
$surname = $_SESSION['surname'] ?? "Not provided";
$email = $_SESSION['email'] ?? "Not provided";
$address0 = $_SESSION['address0'] ?? "Not provided";

// Insert user data into "users" table
$userStmt = $conn->prepare("INSERT INTO users (first_name, surname, email, address0) VALUES (?, ?, ?, ?)");
$userStmt->bind_param("ssss", $first_name, $surname, $email, $address0);
$userStmt->execute();
$user_id = $userStmt->insert_id;
$userStmt->close();

// Insert typing data into "typing_data" table
if (isset($_SESSION['typing_data']) && is_array($_SESSION['typing_data'])) {
    $typingStmt = $conn->prepare("INSERT INTO typing_data (user_id, key_pressed, press_duration, field_name, time_between_keys) VALUES (?, ?, ?, ?, ?)");
    foreach ($_SESSION['typing_data'] as $entry) {
        $key_pressed = $entry['key'];
        $press_duration = $entry['press_duration'];
        $field_name = $entry['field'];
        $time_between_keys = $entry['time_between_keys'] ?? null;
        $typingStmt->bind_param("isdss", $user_id, $key_pressed, $press_duration, $field_name, $time_between_keys);
        $typingStmt->execute();
    }
    $typingStmt->close();
}

// Close database connection
$conn->close();

// Clear session typing data
unset($_SESSION['typing_data']);

// Display user information
echo "<h1>Collected Information</h1>";
echo "<p>First Name: " . htmlspecialchars($first_name) . "</p>";
echo "<p>Surname: " . htmlspecialchars($surname) . "</p>";
echo "<p>Email: " . htmlspecialchars($email) . "</p>";
echo "<p>Address: " . htmlspecialchars($address0) . "</p>";
echo "<p>Thank you for submitting your information.</p>";

// Increment the session counter
$_SESSION['counter'] = ($_SESSION['counter'] ?? 0) + 1;

// Redirect logic
if ($_SESSION['counter'] <= 10) {
    // Redirect to insertformpg1.php for the next round
    header("Refresh: 5; URL=insertformpg1.php");
    exit();
} else {
    // Clear session and redirect to the final page after 10 rounds
    session_unset();
    session_destroy();
    header("Refresh: 5; URL=finalpage.php");
    exit();
}
?>
