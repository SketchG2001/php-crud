<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");


include("config.php");
$username = $_GET['username'];
$sql = "DELETE FROM `userDB` WHERE username='$username'";
$result = $conn->query($sql);

$succesmsg = "user has been Deleted succesfully";
header("Location: adminDashboard.php?success=".urlencode($succesmsg));
exit();

?>