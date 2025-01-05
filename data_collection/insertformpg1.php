<?php
session_start();

// Initialize counter if it doesn't exist
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 1;
}

// Determine the correct suffix for the counter (1st, 2nd, 3rd, etc.)
$counter = $_SESSION['counter'];
$suffix = ($counter == 1) ? "1st" : (($counter == 2) ? "2nd" : (($counter == 3) ? "3rd" : "{$counter}th"));

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store user inputs in session
    $_SESSION['first_name'] = htmlspecialchars($_POST['first_name'], ENT_QUOTES, 'UTF-8');
    $_SESSION['surname'] = htmlspecialchars($_POST['surname'], ENT_QUOTES, 'UTF-8');
    
    // Redirect to page 2
    header('Location: insertformpg2.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 1 - Basic Information</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        let typingData = [];
        let lastKeyUpTime = null;

        // Capture typing data from input fields
        document.querySelectorAll("input").forEach(input => {
            input.addEventListener("keydown", e => {
                e.target.dataset.startTime = new Date().getTime();
            });

            input.addEventListener("keyup", e => {
                const startTime = parseInt(e.target.dataset.startTime || 0, 10);
                const endTime = new Date().getTime();
                const keyDuration = endTime - startTime;
                const timeSinceLastKeyUp = lastKeyUpTime ? endTime - lastKeyUpTime : null;

                lastKeyUpTime = endTime;

                typingData.push({
                    field: e.target.name,
                    key: e.key,
                    press_duration: keyDuration,
                    time_between_keys: timeSinceLastKeyUp,
                });
            });
        });

        // Handle form submission and send typing data
        document.querySelector("form").addEventListener("submit", e => {
            e.preventDefault();

            fetch("algor_time_stamp.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ typing_data: typingData })
            })
            .then(() => e.target.submit())
            .catch(err => console.error("Error:", err));
        });
    });
    </script>
</head>
<body>
    <div class="form-container">
        <h1><?php echo $suffix; ?> Time</h1>
        <h2>Step 1 - Basic Information</h2>
        <p>Please enter your first name and surname to proceed to the next step.</p>
        <form action="insertformpg1.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" placeholder="Enter your surname" required>
            </div>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
