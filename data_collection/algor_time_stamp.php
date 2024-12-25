<?php
session_start();

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and decode the input data
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Check if 'typing_data' exists in the decoded data
    if (isset($data['typing_data']) && is_array($data['typing_data'])) {
        // Initialize session variable for typing data if not already set
        if (!isset($_SESSION['typing_data'])) {
            $_SESSION['typing_data'] = [];
        }

        // Append the new typing data to the session
        foreach ($data['typing_data'] as $entry) {
            if (isset($entry['key'], $entry['time'], $entry['field'])) {
                // Validate data structure before adding
                $_SESSION['typing_data'][] = [
                    'key' => htmlspecialchars($entry['key']),
                    'time' => floatval($entry['time']),
                    'field' => htmlspecialchars($entry['field'])
                ];
            }
        }

        echo "Typing data saved successfully in session!";
    } else {
        http_response_code(400); // Bad request
        echo "Invalid or missing 'typing_data'.";
    }
} else {
    http_response_code(405); // Method not allowed
    echo "Invalid request method.";
}
?>
