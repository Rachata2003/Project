<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$dbname = "userdata"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO info (user_name, user_surname, user_email, user_address) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $first_name, $surname, $email, $address);

// Set parameters and execute
$first_name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : "Not provided";
$surname = isset($_SESSION['surname']) ? $_SESSION['surname'] : "Not provided";
$email = isset($_SESSION['personal_email']) ? $_SESSION['personal_email'] : "Not provided";
$address = isset($_SESSION['address']) ? $_SESSION['address'] : "Not provided";

$stmt->execute();

// Close connection
$stmt->close();
$conn->close();

// Display collected information
echo "<h1>Collected Information</h1>";
echo "<p>First Name: " . htmlspecialchars($first_name) . "</p>";
echo "<p>Surname: " . htmlspecialchars($surname) . "</p>";
echo "<p>Email: " . htmlspecialchars($email) . "</p>";
echo "<p>Address: " . htmlspecialchars($address) . "</p>";
echo "<p>Thank you for submitting your information.</p>";

// Increment the counter for the next loop
$_SESSION['counter']++;


// Redirect to insertformpg1.php after 5 seconds
header("Refresh: 5; URL=insertformpg1.php");

// Check if the counter has reached 10
if ($_SESSION['counter'] >= 11) {
    // Clear session data for new entries
    session_unset();
    session_destroy();

    // Redirect to finalpage.php
    header("Refresh: 5; URL=finalpage.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Submitted</title>
</head>
<body>
    <p>You will be redirected to the first form in a few seconds...</p>
</body>
</html>
