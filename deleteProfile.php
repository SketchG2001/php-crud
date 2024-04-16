<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}
include("config.php");
$username = $_GET['username'];
$sql = "DELETE FROM `userDB` WHERE username='$username'";
$result = $conn->query($sql);
session_start(); //to ensure you are using same session
session_destroy(); 
$succesmsg = "You Profile has been Deleted succesfully";
header("Location: newregister.php?error=".urlencode($succesmsg));
exit();

?>