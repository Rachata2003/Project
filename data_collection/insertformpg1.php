<?php
session_start();

// Initialize counter if it doesn't exist
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 1;
}

// Determine the correct suffix for the counter (1st, 2nd, 3rd, etc.)
$counter = $_SESSION['counter'];
$suffix = ($counter == 1) ? "1st" : (($counter == 2) ? "2nd" : (($counter == 3) ? "3rd" : "{$counter}th"));

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['surname'] = $_POST['surname'];
    header('Location: insertformpg2.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $suffix; ?> Time Name</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
    document.addEventListener("DOMContentLoaded", function () {
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

        // Handle form submission
        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault();

            fetch("algor_time_stamp.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ typing_data: typingData })
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                this.submit(); // Proceed with form submission
            })
            .catch(error => console.error("Error:", error));
        });
    });
    </script>
</head>
<body>
    <div class="e1_2">
        <span class="e4_7"><?php echo $suffix; ?> Time</span>
        <span class="e4_19">Please input: First Name and Surname<br>Ex: James Bond</span>
        <form action="insertformpg1.php" method="POST">
            <div class="e4_28">
                <input type="text" class="ei4_28_54616_25488" name="first_name" placeholder="Enter First Name" required>
            </div>
            <div class="e4_28">
                <input type="text" class="ei4_28_54616_25488" name="surname" placeholder="Enter Surname" required>
            </div>
            <span class="e4_34">After finishing this section, please press Next.</span>
            <button type="submit" class="next_button">Next</button>
        </form>
    </div>
</body>
</html>
