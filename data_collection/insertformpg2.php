<?php
session_start();

// Use the existing counter
$counter = $_SESSION['counter'];
$suffix = ($counter == 1) ? "1st" : (($counter == 2) ? "2nd" : (($counter == 3) ? "3rd" : "{$counter}th"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['personal_email'] = $_POST['personal_email'];
    header('Location: insertformpg3.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $suffix; ?> Time Email</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="e1_2">
        <span class="e4_7"><?php echo $suffix; ?> Time</span>
        <span class="e4_19">Please input: Personal Email<br>Ex: James007@spymail.com</span>
        <form action="insertformpg2.php" method="POST">
            <div class="e4_28">
                <input type="email" class="ei4_28_54616_25488" name="personal_email" placeholder="Enter your email" required>
            </div>
            <span class="e4_34">After finishing this section, please press Next.</span>
            <button type="submit" class="next_button">Next</button>
        </form>
    </div>
</body>
</html>
