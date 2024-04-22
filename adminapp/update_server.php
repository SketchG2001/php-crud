<?php
// Start session
session_start();

// Include database configuration file
include("config.php");

// Define upload folder path
$currentDirectory = dirname(__FILE__);
$parentDirectory = dirname($currentDirectory);
$uploadsFolderPath = $parentDirectory . "/uploads";

// Check if form is submitted
if (isset($_POST["submit"])) {
    // Retrieve form data
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $username = $_POST["username"];
    $gender = $_POST["gender"];
    $dob = $_POST["date"];
    $role = $_POST["role"];
    $skills = $_POST["skills"];
    $age = $_POST["age"];
    $email = $_POST["femail"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Prepare and execute SQL query to retrieve user information
    $stmt = $conn->prepare("SELECT * FROM userDB WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbfile = $row["file"];

        // Check if file is uploaded
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
            if (!empty($dbfile)) {
                // Delete existing file
                unlink($uploadsFolderPath . "/" . basename($dbfile));
            }

            // Handle file upload
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
                        $fileNamenew = uniqid('', true) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                        $fileDestination = $uploadsFolderPath . "/" . $fileNamenew;
                        move_uploaded_file($fileTMPName, $fileDestination);
                        $dbfile = 'uploads/' . $fileNamenew;
                    } else {
                        // File size exceeds limit
                        $error_message = 'File size is too large.';
                        header("Location: update.php?error=" . urlencode($error_message));
                        exit();
                    }
                } else {
                    // File upload error
                    $error_message = "There was an error uploading the file.";
                    header("Location: update.php?error=" . urlencode($error_message));
                    exit();
                }
            } else {
                // Invalid file format
                $error_message = "Invalid file format. Allowed formats are JPG, JPEG, PNG, and PDF.";
                header("Location: update.php?error=" . urlencode($error_message));
                exit();
            }
        }

        // Prepare and execute SQL query to update user information
        $newpassword = (!empty($password)) ? password_hash($password, PASSWORD_DEFAULT) : $row["password"];
        $newfname = ($firstname !== $row["firstname"]) ? $firstname : $row["firstname"];
        $newlname = ($lastname !== $row["lastname"]) ? $lastname : $row["lastname"];
        $newemail = ($email !== $row["email"]) ? $email : $row["email"];
        $newmobile = ($mobile !== $row["mobile"]) ? $mobile : $row["mobile"];
        $newdob = ($dob !== $row["dob"]) ? $dob : $row["dob"];
        $newskills = ($skills !== $row["skills"]) ? $skills : $row["skills"];
        $newrole = ($role !== $row["role"]) ? $role : $row["role"];
        $newage = ($age !== $row["age"]) ? $age : $row["age"];
        $newgender = ($gender !== $row["gender"]) ? $gender : $row["gender"];

        $stmt = $conn->prepare("UPDATE userDB SET firstname=?, lastname=?, email=?, password=?, mobile=?, dob=?, file=?, gender=?, role=?, skills=?, age=? WHERE username=?");
        $stmt->bind_param('ssssssssssss', $newfname, $newlname, $newemail, $newpassword, $newmobile, $newdob, $dbfile, $newgender, $newrole, $newskills, $newage, $username);

        if ($stmt->execute()) {
            // Redirect with success message
            $success_message = "Updated successfully.";
            header("Location: adminDashboard.php?message=" . urlencode($success_message));
            exit();
        } else {
            // Error updating data
            $error_message = "Error updating data.";
            header("Location: update.php?error=" . urlencode($error_message));
            exit();
        }
    } else {
        // User not found
        $error_message = "User not found.";
        header("Location: update.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // Invalid request
    $error_message = "Invalid request.";
    header("Location: update.php?error=" . urlencode($error_message));
    exit();
}
?>
