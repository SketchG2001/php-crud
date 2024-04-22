<?php
// Database connection parameters
$servername = "localhost";
$dbusername = "root";
$dbpassword = "vkaps001";
$dbname = "signup";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, display error message and terminate script
    die("Failed to connect to the database: " . $conn->connect_error);
}
?>
