<?php

// session_start();
// Check if the success message is present in the URL


session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION["username"])) {
    $error_message = "you have to login first.";
    header("Location: admin.php?message=" . urlencode($error_message));
    exit();
}


// messages from adduserserver.php
if (isset($_GET['message'])) {
    // Retrieve and decode the message from the URL parameter
    $message = urldecode($_GET['message']);
    // Display the message as a dismissable alert
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
    echo $message;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

if (isset($_GET['success'])) {
    // Decode the URL-encoded success message
    $success_message = urldecode($_GET['success']);
    // Display the success message as a dismissable alert
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo $success_message;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}


$username = $_SESSION["username"];
// echo"$username";
// echo"<br>";
include("config.php");
$stmt = $conn->prepare("SELECT id, username,role FROM userDB WHERE username=?");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // User found, verify password
    $row = $result->fetch_assoc();
    $role = $row["role"];
    // echo"$role";

    if ($role == "admin") {
        $sql = "SELECT * FROM userDB";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<div class='mt-3' style='text-align: center;'>";
            echo "<h1 class='table-info' style='text-align: center; color: blue; font-size: 24px;'>Admin Views<span>. $username.</span></h1>";

            echo "</div>";
            echo "<div class='mt-3' style='text-align: right;'>";
            echo '<td class="btn btn-primary" style="text-align: right;" ><a href="adminlogout.php" class="btn btn-primary">Logout</a></td>';
            echo "</div>";
            echo "<hr>";
            echo '<table class="table-primary table table-striped ">';
            echo '<tr><th>userid</><th>First Name</th><th>Last Name</th><th>Username</th><th>Gender</th><th>DOB</th><th>Age</th><th>Email</th>
                    <th>Mobile</th><th>Profile</th><th>skills</th><th>Role</th><th>Update</th><th>Delete</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $userid = $row['id'];
                $firstname = $row["firstname"];
                $lastname = $row["lastname"];
                $username = $row["username"];
                $gender = $row["gender"];
                $dob = $row["dob"];
                $role = $row["role"];
                $skill = $row["skills"];
                $age = $row["age"];
                $updates = $row["updates"];
                $email = $row["email"];
                $mobile = $row["mobile"];
                $image = $row["file"];

                
                $imagePath = '../../'.$image;
                   



                if ($role == "user") {
                    echo '<tr>';
                    echo '<td class="table-info">' . $userid . '</td>';
                    echo '<td class="table-info">' . $firstname . '</td>';
                    echo '<td class="table-info">' . $lastname . '</td>';
                    echo '<td class="table-info">' . $username . '</td>';
                    echo '<td class="table-info">' . $gender . '</td>';
                    echo '<td class="table-info">' . $dob . '</td>';
                    echo '<td class="table-info">' . $age . '</td>';
                    echo '<td class="table-info">' . $email . '</td>';
                    echo '<td class="table-info">' . $mobile . '</td>';
                    echo '<td class="table-info"><img src="'.$imagePath.'" alt="User Image" style="max-width: 90px;"></td>'; // Displaying image as an example
                    echo '<td class="table-info">' . $skill . '</td>';
                    echo '<td class="table-info">' . $role . '</td>';
                    echo '<td class="table-info"><a href="update.php?username=' . $username . '" class="btn btn-primary">Edit Details</a></td>';
                    echo '<td class="table-info"><a href="admindel.php?username=' . $username . '" class="btn btn-primary">Delete User</a></td>';
                    // echo '<td class="table-info"><a href="forgetpassword.php?username=' . $username . '" class="btn btn-primary">change password</a></td>';
                    echo '</tr>';
                }
            }
        }

        echo '</table>';
    } else {
        echo "No result";
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    
    <div class="container" style="text-align: right; margin-right: 8px;">
        <a href="adduser.php"><img class="btn btn-primary" src="addsvg.svg" alt=""></a>
    </div>

</body>

</html>