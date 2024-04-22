<?php
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

// Retrieve user information from the database
$username = $_SESSION["username"];
$sql = "SELECT * FROM `userDB` WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $image = $row["file"];
    }
}

// Initialize error and success messages
$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload logic
    if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
        $file = $_FILES['file'];
        $filename = $_FILES['file']['name'];
        $fileTMPName = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];
        $filetype = $_FILES['file']['type'];

        $fileExt = explode('.', $filename);
        $fileactualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileactualExt, $allowed)) {
            if ($fileerror === 0) {
                if ($filesize < 1000000) {
                    $fileNamenew = uniqid('', true) . "." . $fileactualExt;
                    $fileDestination = 'uploads/' . $fileNamenew;
                    move_uploaded_file($fileTMPName, $fileDestination);

                    // Update user information in the database
                    $stmt = $conn->prepare("UPDATE userDB SET file=? WHERE username=?");
                    $stmt->bind_param('ss', $fileDestination, $username);

                    if ($stmt->execute()) {
                        $success_message = "File updated successfully.";
                        header("Location: welcome.php");
                    } else {
                        $error_message = "Error updating file.";
                    }
                } else {
                    $error_message = 'File size is too large.';
                }
            } else {
                $error_message = "There was an error uploading the file.";
            }
        } else {
            $error_message = "Invalid file format. Allowed formats are JPG, JPEG, PNG, and PDF.";
        }
    } else {
        // No file uploaded
        $error_message = "No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap
