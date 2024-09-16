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
