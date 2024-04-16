<?php
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
