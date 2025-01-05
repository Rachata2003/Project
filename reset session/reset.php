<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the first form (or the homepage)
header('Location: insertformpg1.php');
exit();
?>
