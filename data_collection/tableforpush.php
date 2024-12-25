<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "userdata"; // Database name with "users" and "typing_data" tables

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert user data into the "users" table
$stmt = $conn->prepare("INSERT INTO users (first_name, surname) VALUES (?, ?)");
$stmt->bind_param("ss", $first_name, $surname);

// Retrieve session data
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "Not provided";
$surname = isset($_SESSION['surname']) ? $_SESSION['surname'] : "Not provided";

// Execute the query and get the inserted user ID
$stmt->execute();
$user_id = $stmt->insert_id;
$stmt->close();

// Insert typing data into the "typing_data" table if available
if (isset($_SESSION['typing_data']) && is_array($_SESSION['typing_data'])) {
    $typing_stmt = $conn->prepare("INSERT INTO typing_data (user_id, key_pressed, press_duration, field_name, time_between_keys) VALUES (?, ?, ?, ?, ?)");

    foreach ($_SESSION['typing_data'] as $typing_entry) {
        $key_pressed = $typing_entry['key'];
        $press_duration = $typing_entry['time'];
        $field_name = $typing_entry['field'];
        $time_between_keys = isset($typing_entry['time_between_keys']) ? $typing_entry['time_between_keys'] : null;

        $typing_stmt->bind_param("isdss", $user_id, $key_pressed, $press_duration, $field_name, $time_between_keys);
        $typing_stmt->execute();
    }
    $typing_stmt->close();
}

// Close database connection
$conn->close();

// Clear session typing data for next iteration
unset($_SESSION['typing_data']);

// Display user information
echo "<h1>Collected Information</h1>";
echo "<p>First Name: " . htmlspecialchars($first_name) . "</p>";
echo "<p>Surname: " . htmlspecialchars($surname) . "</p>";
echo "<p>Thank you for submitting your information.</p>";

// Increment the counter for the next loop
$_SESSION['counter']++;

// Redirect to insertformpg1.php after 5 seconds
if ($_SESSION['counter'] <= 10) {
    header("Refresh: 5; URL=insertformpg1.php");
} else {
    // Clear session data after 10 iterations and redirect to final page
    session_unset();
    session_destroy();
    header("Refresh: 5; URL=finalpage.php");
}
?>
