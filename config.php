<?php
// $servername = "localhost";
// $username = "root";
// $password = "vkaps001";

// // Create connection
// $conn = new mysqli($servername, $username, $password);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";


// SQL query to create a database
// $sql = "CREATE DATABASE signup";

// if ($conn->query($sql) === TRUE) {
//     echo "Database created successfully";
// } else {
//     echo "Error creating database: " . $conn->error;
// }

// // Close connection
// $conn->close();


$servername = "localhost";
$dbusername = "root";
$dbpassword = "vkaps001";
$dbname = "signup";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("failed to connect with database: " . $conn->connect_error);
}
// else{
//     echo"connected";
// }




?>