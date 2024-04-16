<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page
$message = "You have been loged out Successfully.";
header("Location: admin.php?success=".urlencode($message));
exit();
?>
