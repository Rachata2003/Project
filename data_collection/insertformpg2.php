<?php
session_start();

// Determine the correct suffix for the counter (1st, 2nd, 3rd, etc.)
$counter = $_SESSION['counter'];
$suffix = ($counter == 1) ? "1st" : (($counter == 2) ? "2nd" : (($counter == 3) ? "3rd" : "{$counter}th"));

// Redirect to page 1 if required session data is missing
if (!isset($_SESSION['first_name'], $_SESSION['surname'])) {
    header('Location: insertformpg1.php');
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store user inputs in session
    $_SESSION['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    // Redirect to page 3
    header('Location: insertformpg3.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step 2 - Email Information</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        let typingData = [];
        let lastKeyUpTime = null;

        // Collect typing data from input fields
        document.querySelectorAll("input").forEach(inputField => {
            inputField.addEventListener("keydown", function (event) {
                const startTime = new Date().getTime();
                event.target.dataset.startTime = startTime;
            });

            inputField.addEventListener("keyup", function (event) {
                const endTime = new Date().getTime();
                const startTime = parseInt(event.target.dataset.startTime || endTime);
                const keyPressDuration = endTime - startTime;

                const timeSinceLastKeyUp = lastKeyUpTime ? endTime - lastKeyUpTime : null;
                lastKeyUpTime = endTime;

                typingData.push({
                    key: event.key,
                    time: keyPressDuration,
                    time_between_keys: timeSinceLastKeyUp,
                    field: event.target.name
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
        <h2>Step 2 - Email Information</h2>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>! Please provide your email to proceed.</p>
        <form action="insertformpg2.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit">Next</button>
        </form>
    </div>
</body>
</html>
