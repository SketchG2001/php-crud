<?php
// Start session
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to the login page with success message
$message = "You have been logged out successfully.";
header("Location: admin.php?success=" . urlencode($message));
exit();
?>
