<?php
session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
$logOutmsg = "You have been loged out succesfully.";
header("Location: login.php?error=" . urlencode($logOutmsg));
exit();
