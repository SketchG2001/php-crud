<?php
// echo"hello";
include("config.php");
// $targetDir = "uploads/";
if (isset($_POST["submit"])) {
    $file = $_FILES['file'];
    // print_r($file); 
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
                if (move_uploaded_file($fileTMPName, $fileDestination)) {

                    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                    // echo $password."<br>";
                    // echo $_POST["fname"]."<br>";
                    // echo $_POST["lname"]."<br>";
                    //  echo $_POST["username"]."<br>";
                    //  echo $_POST["femail"]."<br>";
                    //  echo $_POST["mobile"]."<br>";
                    //  echo $_POST["password"]."<br>";
                    //  echo $_POST["cpassword"]."<br>";
                    //  echo $fileDestination ."<br>";
                    //  echo $_POST["date"]."<br>";
                    //  echo $_POST["update"]."<br>";
                    //  echo $_POST["gender"]."<br>";
                    //  echo $_POST["role"]."<br>";
                    //  echo $_POST["uagevalue"]."<br>";
                    //  echo $_POST["skills"]."<br>";
                    //  if (!isset($_POST["update"])){
                    //     echo"empty";
                    //  }else{
                    //     echo "yes";
                    //  }
                    // die();

                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (empty($_POST["fname"])) {
                            // echo "first name required";
                            $error_message = "first name required";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/^[a-zA-Z]+$/", $_POST["fname"])) {
                            $firstname = $_POST["fname"];
                        } else {
                            $error_message = "First Name must contains only alphabetic characters.";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        }
                        echo "$firstname <br>";
                        // exit();
                        if (empty($_POST["lname"])) {
                            // echo "last name required";
                            $error_message = "last name required";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/^[a-zA-Z]+$/", $_POST["lname"])) {
                            $lastname = $_POST["lname"];
                        } else {
                            $error_message = "Last Name must contains only alphabetic characters.";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        }
                        echo "$lastname <br>";
                        if (empty($_POST["username"])) {
                            // echo "username required";
                            $error_message = "username required";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/[0-9]/", $_POST["username"])) {
                            $username = $_POST["username"];
                        } else {
                            $error_message = "username must contains a number";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        }
                        echo "$username <br>";
                        if (empty($_POST["femail"])) {
                            // echo "Email required";
                            $error_message = "Email must required.";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $_POST["femail"])) {
                            $email = $_POST["femail"];
                        } else {
                            $error_message = "invalid email address.";
                            header("newregister.php" . urlencode($error_message));
                        }
                        echo $email . "<br>";
                        if (empty($_POST["mobile"])) {
                            // echo "Email required";
                            $error_message = "Mobile number is required.";
                            header("newregister.php" . urlencode($error_message));
                        } elseif (preg_match("/^\d{10}$/", $_POST["mobile"]) && strlen($_POST["mobile"]) == 10) {
                            $mobile = $_POST["mobile"];
                        } else {
                            $error_message = "Invalid mobile number.";
                            header("newregister.php" . urlencode($error_message));
                            exit();
                        }
                        echo $mobile . "<br>";
                        if (empty($_POST["password"])) {
                            $error_message = "password required.";
                            header("newregister.php" . urlencode($error_message));
                            exit();
                        } elseif ($_POST["password"] != $_POST["cpassword"]) {
                            $error_message = "confirm password doesn't matching";
                            header("newregister.php" . urlencode($error_message));
                            exit();
                        } else {
                            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
                            echo $password . "<br>";
                        }
                        $date_regex = '/^\d{4}-\d{2}-\d{2}$/';
                        if (empty($_POST["date"])) {
                            $error_message = "Please enter the date is required.";
                            header("newregister.php" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["date"]) && preg_match("$date_regex", $_POST["date"])) {
                            $date = $_POST["date"];
                        }
                        echo $date . "<br>";
                        // exit();
                        if (!isset($_POST["gender"])) {
                            $error_message = "Please choose you gender";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["gender"]) && $_POST["gender"] === "male" || $_POST["gender"] === "female") {
                            $gender = strtolower($_POST["gender"]);
                        }
                        echo "$gender" . "<br>";
                        // exit();

                        if (!isset($_POST["role"])) {
                            $error_message = "please select you role.";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                        } elseif (isset($_POST["role"]) && $_POST["role"] === "admin" || $_POST["role"] === "user") {
                            $role = strtolower($_POST["role"]);
                        } else {
                            $error_message = "role error please check";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                        }
                        echo $role . "<br>";
                        if (!isset($_POST["uagevalue"]) || empty($_POST["uagevalue"])) {
                            $error_message = "please select your age.";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["uagevalue"])) {
                            $age = $_POST["uagevalue"];
                            if ($age < 18 || $age > 100) {
                                $error_message = "invalid age value.";
                                header("Location: newregister.php?error=" . urlencode($error_message));
                                exit();
                            }
                        }
                        echo $age . "<br>";

                        if (!isset($_POST["skills"]) || empty($_POST["skills"])) {
                            $error_message = "Please select your skill";
                            header("Location: newregister.php?error=" . urlencode($error_message));
                            exit();
                        } elseif (isset($_POST["skills"])) {
                            $skill = $_POST["skills"];
                        }
                        echo $skill . "<br>";


                        $update = $_POST["update"];
                        if (!isset($update)) {
                            $update = "NO";
                        } elseif ($update == 1) {
                            $update = "YES";
                        }
                        echo $update . "<br>";
                    }
                    // echo $firstname ."<br>";
                    // echo $lastname ."<br>";
                    // echo $email ."<br>";
                    // echo $password ."<br>";
                    // echo $username ."<br>";
                    $sql = "INSERT INTO userDB (firstname, lastname, username, email, mobile, password,dob,file, gender,role,skills, age,updates)VALUES ('$firstname','$lastname','$username','$email','$mobile','$password','$date','$fileDestination','$gender','$role','$skill','$age','$update')";
                    if ($conn->query($sql)) {

                        $success_message = "You have registered succesfully";
                        header("Location: login.php?message=" . urlencode($success_message));
                        exit();
                    } else {
                        $success_message = "something went wrong please try again. <br>" . $conn->error;
                        header("Location: newregister.php?message=" . urlencode($success_message));
                        exit();
                    }
                    $conn->close();
                }
            } else {

                $error_message = 'file size too large';
                header("Location: newregister.php?message=" . urlencode($error_message));
                exit();
            }
        } else {
            $error_message = "there was an error.";
            header("Location: newregister.php?message=" . urlencode($error_message));
            exit();
        }
    } else {
        $error_message = 'file type is not allowed';
        header("Location: newregister.php?message=" . urlencode($error_message));
        exit();
    }
}
