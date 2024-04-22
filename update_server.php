<?php
// Set error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the configuration file
include("config.php");

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Fetch form data
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $username = $_POST["username"];
    $gender = $_POST["gender"];
    $dob = $_POST["date"];
    $skills = $_POST["skills"];
    $age = $_POST["age"];
    $email = $_POST["femail"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM userDB WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If user found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbfirstname = $row["firstname"];
        $dblastname = $row["lastname"];
        $dbemail = $row["email"];
        $dbpassword = $row["password"];
        $dbmobile = $row["mobile"];
        $dbdob = $row["dob"];
        $dbgender = $row["gender"];
        $dbskills = $row["skills"];
        $dbage = $row["age"];

        // Check password and update if provided
        if (empty($password)) {
            $newpassword = $dbpassword;
        } else {
            $newpassword = password_hash($password, PASSWORD_DEFAULT);
        }

        // Update data if different
        $newfname = ($firstname !== $dbfirstname) ? $firstname : $dbfirstname;
        $newlname = ($lastname !== $dblastname) ? $lastname : $dblastname;
        $newemail = ($email !== $dbemail) ? $email : $dbemail;
        $newmobile = ($mobile !== $dbmobile) ? $mobile : $dbmobile;
        $newdob = ($dob !== $dbdob) ? $dob : $dbdob;
        $newskills = ($skills !== $dbskills) ? $skills : $dbskills;
        $newage = ($age !== $dbage) ? $age : $dbage;
        $newgender = ($gender !== $dbgender) ? $gender : $dbgender;

        // If new file is uploaded
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
            $file = $_FILES['file'];
            $filename = $_FILES['file']['name'];
            $fileTMPName = $_FILES['file']['tmp_name'];
            $filesize = $_FILES['file']['size'];
            $fileerror = $_FILES['file']['error'];
            $filetype = $_FILES['file']['type'];

            // Define allowed file extensions
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');
            $fileExt = explode('.', $filename);
            $fileactualExt = strtolower(end($fileExt));

            // Check if file extension is allowed
            if (in_array($fileactualExt, $allowed)) {
                // Retrieve file destination from database
                $fileDestination = $row["file"];
                
                // Check for file upload error
                if ($fileerror === 0) {
                    // Check file size
                    if ($filesize < 1000000) {
                        // Remove existing file if exists
                        if (file_exists($fileDestination)) {
                            unlink($fileDestination);
                        }

                        // Move new file to destination
                        $fileNamenew = uniqid('', true) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                        $fileDestination = 'uploads/' . $fileNamenew;
                        move_uploaded_file($fileTMPName, $fileDestination);

                        // Update user information in database
                        $stmt = $conn->prepare("UPDATE userDB SET firstname=?, lastname=?, email=?, password=?, mobile=?, dob=?, file=?, gender=?, skills=?, age=? WHERE username=?");
                        $stmt->bind_param('sssssssssss', $newfname, $newlname, $newemail, $newpassword, $newmobile, $newdob, $fileDestination, $newgender, $newskills, $newage, $username);

                        if ($stmt->execute()) {
                            $success_message = "Updated successfully.";
                            header("Location: welcome.php?message=" . urlencode($success_message));
                            exit();
                        } else {
                            $error_message = "Error updating data.";
                            header("Location: update.php?error=" . urlencode($error_message));
                            exit();
                        }
                    } else {
                        $error_message = 'File size is too large.';
                        header("Location: update.php?error=" . urlencode($error_message));
                        exit();
                    }
                } else {
                    $error_message = "There was an error uploading the file.";
                    header("Location: update.php?error=" . urlencode($error_message));
                    exit();
                }
            } else {
                $error_message = "Invalid file format. Allowed formats are JPG, JPEG, PNG, and PDF.";
                header("Location: update.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            // If no new file uploaded, update other user information
            $stmt = $conn->prepare("UPDATE userDB SET firstname=?, lastname=?, email=?, password=?, mobile=?, dob=?, gender=?, skills=?, age=? WHERE username=?");
            $stmt->bind_param('ssssssssss', $newfname, $newlname, $newemail, $newpassword, $newmobile, $newdob, $newgender, $newskills, $newage, $username);
            if ($stmt->execute()) {
                $success_message = "Your Profile has been Updated successfully.";
                header("Location: welcome.php?message=" . urlencode($success_message));
                exit();
            } else {
                $error_message = "Error updating data.";
                header("Location: update.php?error=" . urlencode($error_message));
                exit();
            }
        }
    } else {
        $error_message = "User not found.";
        header("Location: update.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    $error_message = "Invalid request.";
    header("Location: update.php?error=" . urlencode($error_message));
    exit();
}
?>
