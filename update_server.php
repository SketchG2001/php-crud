<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config.php");

if (isset($_POST["submit"])) {
    // Fetch form data
    $firstname = $_POST["fname"];
    $lastname = $_POST["lname"];
    $username = $_POST["username"];
    $gender = $_POST["gender"];
    $dob = $_POST["date"];
    // $role = $_POST["role"];
    $skills = $_POST["skills"];
    $age = $_POST["age"];
    $email = $_POST["femail"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // echo $firstname."<br>"; 
    // echo $lastname ."<br>";
    // echo $username ."<br>";
    // echo $gender. "<br>" ;
    // echo $dob. "<br>" ;
    // echo $role. "<br>";
    // echo $skill;
    // echo $age. "<br>" ;
    // echo $email . "<br>";
    // echo $mobile . "<br>";
    // echo $password . "user input <br>";
    // echo $cpassword . "user input <br>";
    // exit();

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM userDB WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbfirstname = $row["firstname"];
        $dblastname = $row["lastname"];
        $dbemail = $row["email"];
        $dbpassword = $row["password"];
        $dbmobile = $row["mobile"];
        $dbdob = $row["dob"];
        $dbgender = $row["gender"];
        // $dbrole = $row["role"];
        $dbskills = $row["skills"];
        $dbage = $row["age"];
        // $dbfile = $row["file"];
        // print_r($dbfile);
        // exit();

        // echo $dbpassword . "from  db <br>";

        if (empty($password)) {
            // echo"same <br>";
            $newpassword = $dbpassword;
            // echo"$newpassword <br>";
            // exit();

        } else {
            // echo "error <br>";
            $newpassword = password_hash($password, PASSWORD_DEFAULT);
            // echo "$newpassword  <br>";
        }
        // exit();

        // Update data if different
        $newfname = ($firstname !== $dbfirstname) ? $firstname : $dbfirstname;
        $newlname = ($lastname !== $dblastname) ? $lastname : $dblastname;
        $newemail = ($email !== $dbemail) ? $email : $dbemail;
        $newmobile = ($mobile !== $dbmobile) ? $mobile : $dbmobile;
        $newdob = ($dob !== $dbdob) ? $dob : $dbdob;
        $newskills = ($skills !== $dbskills) ? $skills : $dbskills;
        // $newrole = ($role !== $dbrole) ? $role : $dbrole;
        $newage = ($age !== $dbage) ? $age : $dbage;
        $newgender = ($gender !== $dbgender) ? $gender : $dbgender;

        // exit();
        if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
            $file = $_FILES['file'];
            $filename = $_FILES['file']['name'];
            $fileTMPName = $_FILES['file']['tmp_name'];
            $filesize = $_FILES['file']['size'];
            $fileerror = $_FILES['file']['error'];
            $filetype = $_FILES['file']['type'];
            // print_r($file);
            // exit();
            $fileExt = explode('.', $filename);
            $fileactualExt = strtolower(end($fileExt));
            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if (in_array($fileactualExt, $allowed)) {
                $fileDestination = $row["file"];
                if ($fileerror === 0) {
                    if ($filesize < 1000000) {

                        if (file_exists($fileDestination)) {
                            unlink($fileDestination);
                        }

                        // Move new file to destination
                        $fileNamenew = uniqid('', true) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
                        $fileDestination = 'uploads/' . $fileNamenew;
                        move_uploaded_file($fileTMPName, $fileDestination);

                        // Update user information
                        $stmt = $conn->prepare("UPDATE userDB SET firstname=?, lastname=?, email=?,password=?, mobile=?, dob=?,file=?, gender=?, skills=?, age=? WHERE username=?");
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
            $stmt = $conn->prepare("UPDATE userDB SET firstname=?, lastname=?, email=?,password=?, mobile=?, dob=?, gender=?, skills=?, age=? WHERE username=?");
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
