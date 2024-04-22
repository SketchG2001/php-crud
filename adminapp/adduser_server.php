<?php
// echo"hello";


// DB connection file
include("config.php");

// getting current directory name 
$currentDirectory = dirname(__FILE__);
// parent directory of the curent directory
$parentDirectory = dirname($currentDirectory);

// files upload location
$uploadsFolderPath = $parentDirectory . "/uploads";

// collect data from the html
if (isset($_POST["submit"])) {


    // file processing
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
                $fileDestination = $uploadsFolderPath . "/" . $fileNamenew;
            //   moving file to the uploads folder
                if (move_uploaded_file($fileTMPName, $fileDestination)) {
                    $dbfile = 'uploads/' . $fileNamenew;
                    // converting password to the hash 
                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

                    // processing user data with validation
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (empty($_POST["fname"])) {
                            $error_message = "first name required";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/^[a-zA-Z]+$/", $_POST["fname"])) {
                            $firstname = $_POST["fname"];
                        } else {
                            $error_message = "First Name must contains only alphabetic characters.";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        }
                        echo "$firstname <br>";
                       
                        if (empty($_POST["lname"])) {
                            
                            $error_message = "last name required";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/^[a-zA-Z]+$/", $_POST["lname"])) {
                            $lastname = $_POST["lname"];
                        } else {
                            $error_message = "Last Name must contains only alphabetic characters.";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        }
                        echo "$lastname <br>";
                        if (empty($_POST["username"])) {
                            
                            $error_message = "username required";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/[0-9]/", $_POST["username"])) {
                            $username = $_POST["username"];
                        } else {
                            $error_message = "username must contains a number";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        }
                        
                        if (empty($_POST["femail"])) {
                            
                            $error_message = "Email must required.";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $_POST["femail"])) {
                            $email = $_POST["femail"];
                        } else {
                            $error_message = "invalid email address.";
                            header("adduser.php" . urlencode($error_message));
                        }
                        echo $email . "<br>";
                        if (empty($_POST["mobile"])) {
                            
                            $error_message = "Mobile number is required.";
                            header("adduser.php" . urlencode($error_message));
                        } elseif (preg_match("/^\d{10}$/", $_POST["mobile"]) && strlen($_POST["mobile"]) == 10) {
                            $mobile = $_POST["mobile"];
                        } else {
                            $error_message = "Invalid mobile number.";
                            header("adduser.php" . urlencode($error_message));
                            exit();
                        }
                        echo $mobile . "<br>";
                        if (empty($_POST["password"])) {
                            $error_message = "password required.";
                            header("adduser.php" . urlencode($error_message));
                            exit();
                        } elseif ($_POST["password"] != $_POST["cpassword"]) {
                            $error_message = "confirm password doesn't matching";
                            header("adduser.php" . urlencode($error_message));
                            exit();
                        } else {
                            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                            
                        }
                        $date_regex = '/^\d{4}-\d{2}-\d{2}$/';
                        if (empty($_POST["date"])) {
                            $error_message = "Please enter the date is required.";
                            header("adduser.php" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["date"]) && preg_match("$date_regex", $_POST["date"])) {
                            $date = $_POST["date"];
                        }
                        
                        
                        if (!isset($_POST["gender"])) {
                            $error_message = "Please choose you gender";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["gender"]) && $_POST["gender"] === "male" || $_POST["gender"] === "female") {
                            $gender = strtolower($_POST["gender"]);
                        }
                        

                        if (!isset($_POST["role"])) {
                            $error_message = "please select you role.";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                        } elseif (isset($_POST["role"]) && $_POST["role"] === "admin" || $_POST["role"] === "user") {
                            $role = strtolower($_POST["role"]);
                        } else {
                            $error_message = "role error please check";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                        }
                       
                        if (!isset($_POST["uagevalue"]) || empty($_POST["uagevalue"])) {
                            $error_message = "please select your age.";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["uagevalue"])) {
                            $age = $_POST["uagevalue"];
                            if ($age < 18 || $age > 100) {
                                $error_message = "invalid age value.";
                                header("Location: adduser.php?error=" . urlencode($error_message));
                                exit();
                            }
                        }
                        

                        if (!isset($_POST["skills"]) || empty($_POST["skills"])) {
                            $error_message = "Please select your skill";
                            header("Location: adduser.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["skills"])) {
                            $skill = $_POST["skills"];
                        }

                        $update = $_POST["update"];
                        if (!isset($update)) {
                            $update = "NO";
                        } elseif ($update == 1) {
                            $update = "YES";
                        }
                        
                    }
                            // database insertion operation to add the new user
                    $sql = "INSERT INTO userDB (firstname, lastname, username, email, mobile, password,dob,file, gender,role,skills, age,updates)VALUES ('$firstname','$lastname','$username','$email','$mobile','$password','$date','$dbfile','$gender','$role','$skill','$age','$update')";
                    if ($conn->query($sql)) {

                        $success_message = "user has been added succesfully";
                        header("Location: adminDashboard.php?message=" . urlencode($success_message));
                        exit();
                    } else {
                        $success_message = "something went wrong please try again. <br>" . $conn->error;
                        header("Location: adduser.php?message=" . urlencode($success_message));
                        exit();
                    }
                    // close db connection
                    $conn->close();
                }

            }
                // any thing wrong with the data or db operation then this code will execute
             else {

                $error_message = 'file size too large';
                header("Location: adduser.php?message=" . urlencode($error_message));
                exit();
            }
        } else {
            $error_message = "there was an error.";
            header("Location: adduser.php?message=" . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = 'file type is not allowed';
        header("Location: adduser.php?message=" . urlencode($error_message));
        exit();
    }
}
