<?php
// Include the configuration file
include("config.php");

// Check if the form is submitted
if (isset($_POST["submit"])) {
    // Retrieve file details
    $file = $_FILES['file'];
    $filename = $_FILES['file']['name'];
    $fileTMPName = $_FILES['file']['tmp_name'];
    $filesize = $_FILES['file']['size'];
    $fileerror = $_FILES['file']['error'];
    $filetype = $_FILES['file']['type'];

    // Define allowed file extensions
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    // Extract file extension
    $fileExt = explode('.', $filename);
    $fileactualExt = strtolower(end($fileExt));

    // Check if the file extension is allowed
    if (in_array($fileactualExt, $allowed)) {
        // Check if there is no file upload error
        if ($fileerror === 0) {
            // Check if the file size is within limit
            if ($filesize < 1000000) {
                // Generate a unique filename
                $fileNamenew = uniqid('', true) . "." . $fileactualExt;
                $fileDestination = 'uploads/' . $fileNamenew;

                // Move the uploaded file to the destination folder
                if (move_uploaded_file($fileTMPName, $fileDestination)) {
                    $dbfile = 'uploads/' . $fileNamenew;

                    // Hash the password
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

                    // Validate form data
                    // Check first name
                    if (empty($_POST["fname"])) {
                        $error_message = "First name is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif (!preg_match("/^[a-zA-Z]+$/", $_POST["fname"])) {
                        $error_message = "First name must contain only alphabetic characters.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $firstname = $_POST["fname"];

                    // Check last name
                    if (empty($_POST["lname"])) {
                        $error_message = "Last name is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif (!preg_match("/^[a-zA-Z]+$/", $_POST["lname"])) {
                        $error_message = "Last name must contain only alphabetic characters.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $lastname = $_POST["lname"];

                    // Check username
                    if (empty($_POST["username"])) {
                        $error_message = "Username is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif (!preg_match("/[0-9]/", $_POST["username"])) {
                        $error_message = "Username must contain a number.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $username = $_POST["username"];

                    // Check email
                    if (empty($_POST["femail"])) {
                        $error_message = "Email is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $_POST["femail"])) {
                        $error_message = "Invalid email address.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $email = $_POST["femail"];

                    // Check mobile
                    if (empty($_POST["mobile"])) {
                        $error_message = "Mobile number is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif (!preg_match("/^\d{10}$/", $_POST["mobile"]) || strlen($_POST["mobile"]) != 10) {
                        $error_message = "Invalid mobile number.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $mobile = $_POST["mobile"];

                    // Check password
                    if (empty($_POST["password"])) {
                        $error_message = "Password is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif ($_POST["password"] != $_POST["cpassword"]) {
                        $error_message = "Passwords do not match.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }

                    // Check date
                    if (empty($_POST["date"])) {
                        $error_message = "Date of birth is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST["date"])) {
                        $error_message = "Invalid date format.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $date = $_POST["date"];

                    // Check gender
                    if (!isset($_POST["gender"])) {
                        $error_message = "Gender is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    } elseif ($_POST["gender"] !== "male" && $_POST["gender"] !== "female") {
                        $error_message = "Invalid gender value.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $gender = $_POST["gender"];

                    // Check role
                    if (!isset($_POST["role"]) || ($_POST["role"] !== "admin" && $_POST["role"] !== "user")) {
                        $error_message = "Invalid role value.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $role = $_POST["role"];

                    // Check age
                    if (!isset($_POST["uagevalue"]) || empty($_POST["uagevalue"])) {
                        $error_message = "Age is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $age = $_POST["uagevalue"];
                    if ($age < 18 || $age > 100) {
                        $error_message = "Invalid age value.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }

                    // Check skills
                    if (!isset($_POST["skills"]) || empty($_POST["skills"])) {
                        $error_message = "Skill is required.";
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $skill = $_POST["skills"];

                    // Check if updates checkbox is checked
                    $update = isset($_POST["update"]) ? "YES" : "NO";

                    // Insert user data into the database
                    $sql = "INSERT INTO userDB (firstname, lastname, username, email, mobile, password, dob, file, gender, role, skills, age, updates) 
                            VALUES ('$firstname', '$lastname', '$username', '$email', '$mobile', '$password', '$date', '$dbfile', '$gender', '$role', '$skill', '$age', '$update')";

                    // Execute the SQL query
                    if ($conn->query($sql)) {
                        $success_message = "You have registered successfully";
                        header("Location: login.php?message=" . urlencode($success_message));
                        exit();
                    } else {
                        $error_message = "Something went wrong. Please try again.<br>" . $conn->error;
                        header("Location: newregister.php?error=" . urlencode($error_message));
                        exit();
                    }
                    $conn->close(); // Close the database connection
                }
            } else {
                $error_message = 'File size is too large';
                header("Location: newregister.php?error=" . urlencode($error_message));
                exit();
            }
        } else {
            $error_message = "There was an error uploading the file.";
            header("Location: newregister.php?error=" . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = 'File type is not allowed';
        header("Location: newregister.php?error=" . urlencode($error_message));
        exit();
    }
}
?>
