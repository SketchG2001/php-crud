<?php
// Start the session
session_start();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page if user is not logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// Include database configuration file
include("config.php");

// Get username from the GET parameters
$username = $_GET['username'];

// Delete user from the database
$sql = "DELETE FROM `userDB` WHERE username='$username'";
$result = $conn->query($sql);

// Destroy session
session_destroy();

// Redirect to registration page with success message
$successMessage = "Your profile has been deleted successfully.";
header("Location: newregister.php?error=" . urlencode($successMessage));
exit();
?>
