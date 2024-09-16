<?php
session_start();

// Use the existing counter
$counter = $_SESSION['counter'];
$suffix = ($counter == 1) ? "1st" : (($counter == 2) ? "2nd" : (($counter == 3) ? "3rd" : "{$counter}th"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['address'] = $_POST['address'];
    header('Location: tableforpush.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $suffix; ?> Time Address</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="e1_2">
        <span class="e4_7"><?php echo $suffix; ?> Time</span>
        <span class="e4_19">Please input: Address<br>Ex: 1/2 Rama 4 Rd., Mahapruttaram, Bang Rak, Bangkok</span>
        <form action="tableforpush.php" method="POST">
            <div class="e4_28">
                <input type="text" class="ei4_28_54616_25488" name="address" placeholder="Enter your address" required>
            </div>
            <span class="e4_34">After finishing this section, please press Next.</span>
            <button type="submit" class="next_button">Next</button>
        </form>
    </div>
</body>
</html>
