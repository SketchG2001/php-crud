<?php
// Start session and prevent caching
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Include the database configuration file
include("config.php");

// Get the username from the URL parameter
$username = $_GET['username'];

// Prepare the SQL query to delete the user
$sql = "DELETE FROM `userDB` WHERE username='$username'";

// Execute the query
$result = $conn->query($sql);

// Redirect to the admin dashboard with a success message
$successMessage = "User has been deleted successfully";
header("Location: adminDashboard.php?success=" . urlencode($successMessage));
exit();
?>
