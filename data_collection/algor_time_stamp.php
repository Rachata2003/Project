<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'userdata');

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from session
$userId = $_SESSION['user_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $typingData = json_decode($input, true)['typing_data'] ?? [];

    if ($userId && !empty($typingData)) {
        foreach ($typingData as $entry) {
            $key = $conn->real_escape_string($entry['key']);
            $duration = floatval($entry['time']);
            $field = $conn->real_escape_string($entry['field']);
            $timeBetween = isset($entry['time_between_keys']) ? floatval($entry['time_between_keys']) : null;

            $sql = "INSERT INTO typing_data (user_id, key_pressed, press_duration, field_name, time_between_keys) 
                    VALUES ('$userId', '$key', '$duration', '$field', " . ($timeBetween !== null ? "'$timeBetween'" : "NULL") . ")";

            if (!$conn->query($sql)) {
                echo "Error: " . $conn->error;
            }
        }
        echo "Typing data saved successfully!";
    } else {
        echo "No valid typing data or user ID.";
    }
}

// Close the connection
$conn->close();
?>
