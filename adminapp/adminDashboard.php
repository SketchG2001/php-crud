<?php

// Start the session
session_start();

// Prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Redirect to login page if user is not logged in
if (!isset($_SESSION["username"])) {
    $error_message = "You have to login first.";
    header("Location: admin.php?message=" . urlencode($error_message));
    exit();
}

// Display messages from adduserserver.php if present
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">';
    echo $message;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

// Display success message if present
if (isset($_GET['success'])) {
    $success_message = urldecode($_GET['success']);
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo $success_message;
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    echo '</div>';
}

// Get username from session
$username = $_SESSION["username"];

// Include database configuration file
include("config.php");

// Prepare and execute SQL query to retrieve user details
$stmt = $conn->prepare("SELECT id, username, role FROM userDB WHERE username=?");
if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

// If user found, verify role
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $role = $row["role"];

    // If user is admin, display admin views
    if ($role == "admin") {
        $sql = "SELECT * FROM userDB";
        $result = $conn->query($sql);

        // HTML for delete user popup
        echo '<div id="deleteUserPopup" class="popup" style="display: none;">
            <div class="popup-content">
                <p>Are you sure you want to delete the user?</p>
                <button id="deleteUserConfirm">Yes</button>
                <button id="deleteUserCancel">No</button>
            </div>
        </div>';

        // If users found, display them in a table
        if ($result->num_rows > 0) {
            echo "<div class='mt-3' style='text-align: center;'>";
            echo "<h1 class='table-info' style='text-align: center; color: blue; font-size: 24px;'>Admin Views<span>.
                $username.</span></h1>";
            echo "</div>";
            echo "<div class='mt-3' style='text-align: right;'>";
            echo '<td class="btn btn-primary" style="text-align: right;"><a href="adminlogout.php" class="btn btn-primary">Logout</a></td>';
            echo "</div>";
            echo "<hr>";
            echo '<table class="table-primary table table-striped ">';
            echo '<tr>
                <th>userid</>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Profile</th>
                <th>skills</th>
                <th>Role</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>';

            // Display user details in table rows
            while ($row = $result->fetch_assoc()) {
                // Fetch user details
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

                // Display user details in table cells
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
                echo '<td class="table-info"><img src="'.'/php-crud/'.$image.'" alt="User Image" style="max-width: 90px;"></td>';
                echo '<td class="table-info">' . $skill . '</td>';
                echo '<td class="table-info">' . $role . '</td>';
                echo '<td class="table-info"><a href="update.php?username=' . $username . '" class="btn btn-primary">Edit Details</a></td>';
                echo '<td class="table-info"><a href="admindel.php?username=' . $username . '" class="btn btn-primary deleteUserLink">Delete User</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    } else {
        echo "No result";
    }
}
?>

<style>
/* CSS Styles for Popup */
.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black background */
    z-index: 9999;
}

.popup-content {
    background-color: white;
    border-radius: 5px;
    padding: 20px;
    width: 300px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.popup-content p {
    margin-top: 0;
    margin-bottom: 10px;
}

.popup-content button {
    margin-right: 10px;
}

.popup-content button:last-child {
    margin-right: 0;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var deleteUserLinks = document.querySelectorAll('.deleteUserLink');
    var deleteUserPopup = document.getElementById('deleteUserPopup');
    var deleteUserConfirm = document.getElementById('deleteUserConfirm');
    var deleteUserCancel = document.getElementById('deleteUserCancel');

    // Add event listener for each delete link
    deleteUserLinks.forEach(function(deleteUserLink) {
        deleteUserLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action of following the link
            deleteUserPopup.style.display = 'block';
            // Set the href of the confirm button to the href of the clicked delete link
            deleteUserConfirm.href = this.href;
        });
    });

    deleteUserConfirm.addEventListener('click', function(event) {
        // Redirect to adminDel.php
        window.location.href = deleteUserConfirm.href;
    });

    deleteUserCancel.addEventListener('click', function(event) {
        deleteUserPopup.style.display = 'none';
    });
});
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</head>

<body>

    <div class="container" style="text-align: right; margin-right: 8px;">
        <a href="adduser.php"><img class="btn btn-primary" src="addsvg.svg" alt=""></a>
    </div>

</body>

</html>
