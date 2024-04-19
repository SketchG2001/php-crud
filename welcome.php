<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION["username"])) {
    $error_message = "you have to login first.";
    header("Location: login.php?message=" . urlencode($error_message));
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <?php 
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>'. $message .'</strong>' .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>
    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="check-circle-fill" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
        <symbol id="info-fill" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
        </symbol>
        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </symbol>
    </svg>
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        <div>Welcome to your profile</div>
        <h3>
            <?php echo $_SESSION["username"] ?>
        </h3>
    </div><br>
    <hr><br>
    <?php
    $username = $_SESSION["username"];

    // Create a database connection
    include("config.php");

    // Sanitize the username to prevent SQL injection
    $username = $conn->real_escape_string($username);

    // Construct the SQL query with the sanitized username
    $sql = "SELECT * FROM userDB WHERE username='$username'";
    $result = $conn->query($sql);

    echo '<div id="deleteUserPopup" class="popup" style="display: none;">
    <div class="popup-content modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p>'.$username.' Are you sure want to delete your account?</p>
            </div>
            <div class="modal-footer">
                <button id="deleteUserConfirm" class="btn btn-primary">Yes</button>
                <button id="deleteUserCancel" class="btn btn-secondary">No</button>
            </div>
        </div>
    </div>
</div>';


    if ($result->num_rows > 0) {
        echo "<h1 class='table-info'>Your profile info</h1>";
        echo '<td class="table-info" style="text-align: right;"><a href="logout.php" class="btn btn-primary">logout</a></td>';
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
            // echo $image;
            // exit;

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
            echo '<td class="table-info"><img src="' . $image . '" alt="User Image" style="max-width: 100px;"></td>'; // Displaying image as an example
            echo '<td class="table-info">' . $skill . '</td>';
            echo '<td class="table-info">' . $role . '</td>';
            echo '<td class="table-info"><a href="update.php?username=' . $username . '" class="btn btn-primary">Edit Details</a></td>';
            echo '<td class="table-info"><a href="deleteProfile.php?username=' . $username . '" class="btn btn-primary deleteUserLink">Delete Account</a></td>';
            // echo '<td class="table-info"><a href="forgetpassword.php?username=' . $username . '" class="btn btn-primary">change password</a></td>';
            echo '</tr>';
        }

        echo '</table>';

        if (isset($_GET['error'])) {
            $succesmsg = $_GET["error"];
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error: </strong>' . $succesmsg .
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    } else {
        echo "0 results";
    }

    $conn->close(); // Close the connection
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
    background-color: rgba(0, 0, 0, 0.5);
    /* semi-transparent black background */
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

        deleteUserLinks.forEach(function(deleteUserLink) {
            deleteUserLink.addEventListener('click', function(event) {
                event.preventDefault();
                deleteUserPopup.style.display = 'block';
                deleteUserConfirm.href = this.href; // Set href for the confirm button
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





    <div class="mx-5 mt-3 ">

    </div>
    <?php

    if (isset($_GET['success'])) {
        $success_message = $_GET["success"];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Error: </strong>' . '' . $success_message .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <script>
    if (!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
        window.location.href = "login.php";
    }
    </script>


</body>

</html>