<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true) {
    // Admin is logged in
    echo "Admin is logged in.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Custom JavaScript -->
    <script src="index.js"></script>
</head>

<style>
    /* Custom CSS */
    .formError {
        color: red;
    }

    .profile {
        height: 100px;
        width: 100px;
        text-align: center;
        margin: auto;
    }

    .col {
        width: 40%;
        margin: auto;
    }

    .form-range {
        width: 100%;
        margin-top: 10px;
        border: 2px solid red;
        border-radius: 20px;
    }

    .form-group p {
        margin-top: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .btn-primary:focus,
    .btn-primary.focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    }

    .btn-lg {
        padding: 10px 30px;
        font-size: 1.25rem;
        width: 35%;
        border-radius: 30px;
    }

    .mt-3 {
        margin-top: 15px;
    }

    .formError {
        color: red;
        font-size: 14px;
        font-weight: bold;
    }

    #serror {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .error-container {
        display: block;
    }
</style>

<body>
    <!-- Display error messages if any -->
    <?php
    if (isset($_GET['error'])) {
        $error_message = urldecode($_GET['error']);
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">' . $error_message .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    if (isset($_GET['message'])) {
        $success_message = urldecode($_GET['message']);
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $success_message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <div class="container form-control">
        <div class="text-center">
            <img class="profile" src="../assets/newac.svg" alt="">
            <h3 class="heading">Add New User</h3>
        </div>
        <!-- Form for adding a new user -->
        <form enctype="multipart/form-data" name="userInfo" action="adduser_server.php" onsubmit="return validateForm()" method="post">
            <!-- First Name Input -->
            <div class="form-group col my-3" id="firstname">
                <input type="text" name="fname" placeholder="First Name" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Last Name Input -->
            <div class="form-group col my-3" id="lastname">
                <input type="text" name="lname" placeholder="Last Name" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Username Input -->
            <div class="form-group col my-3" id="uname">
                <input type="text" name="username" placeholder="Username" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Email Input -->
            <div class="form-group col my-3" id="email">
                <input type="text" name="femail" placeholder="Email" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Date of Birth Input -->
            <div class="form-group col my-3" id="date">
                <label for="datefield" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="datefield" min="1900-01-01" max="2024-12-31" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Mobile Input -->
            <div class="form-group col my-3" id="mobile">
                <input type="tel" placeholder="Mobile" name="mobile" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Password Input -->
            <div class="form-group col my-3" id="pass">
                <input type="password" name="password" value="username" placeholder="Password" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Confirm Password Input -->
            <div class="form-group col my-3" id="cpass">
                <input type="password" name="cpassword" value="username" placeholder="Confirm Password" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Latest Photo Input -->
            <div class="form-group col my-3 file" id="image">
                <label for="file" class="form-label">Latest Photo</label>
                <input type="file" id="file" class="form-control" name="file" accept="image/png, image/gif, image/jpeg" />
                <b><span class="formError"></span></b>
            </div>
            <!-- Checkbox for receiving updates -->
            <div class="form-group col my-3 form-check">
                <input type="checkbox" name="update" value="1" class="form-check-input" id="checkbox" />
                <label class="form-check-label" for="checkbox">Did you want to receive updates</label>
            </div>
            <!-- Gender Selection -->
            <div class="form-group col my-3">
                <div class="container">
                    <label for="datefield" class="form-label">Gender</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="maleradio" name="gender" value="male" />
                        <label class="form-check-label" for="maleradio">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="femaleradio" name="gender" value="female" />
                        <label class="form-check-label" for="femaleradio">Female</label>
                    </div>
                </div>
                <span id="genderError" class="text-danger"></span>
            </div>
            <!-- Hidden field for role -->
            <input type="hidden" name="role" id="role" value="user">
            <!-- Account Type Selection -->
            <div class="form-check form-switch my-3 form-group col">
                <label class="form-label  " for="accountType">Account Type</label>
                <div class="form-check form-switch-inline">
                    <input class="form-check-input" name="actype" type="checkbox" id="adminSwitch" aria-checked="false" />
                    <label class="form-check-label" for="adminSwitch">Admin</label>
                </div>
                <div class="form-check form-switch-inline">
                    <input class="form-check-input" name="actype" type="checkbox" id="userSwitch" aria-checked="true" checked />
                    <label class="form-check-label" for="userSwitch">User</label>
                </div>
            </div>
            <!-- Skills Selection -->
            <div class="form-group col my-3" id="serror">
                <select class="form-group col my-3 form-select" name="skills" id="skills">
                    <option value="non">Select your skill</option>
                    <option value="html">html</option>
                    <option value="css">css</option>
                    <option value="javascript">javascript</option>
                </select><br>
                <div class="error-container">
                    <b><span class="formError"></span></b>
                </div>
            </div>
            <!-- Age Selection -->
            <div class="form-group col my-3">
                <label for="age" class="form-label mt-3">Your Age</label>
                <input type="hidden" name="uagevalue" value="">
                <p id="ageValue"></p>
                <input style="width: 250px" type="range" name="age" class="form-range" min="15" max="100" id="age" /><br>
                <span id="ageError" style="display: inline;" class="text-danger"></span>
            </div>
            <!-- Submit Button -->
            <div class="container text-center">
                <button type="submit" name="submit" class="btn btn-primary btn-lg mt-3">Add User</button>
            </div>
        </form>
    </div>
</body>

<script>
    // Event listeners for toggling admin/user switches
    const adminSwitch = document.getElementById("adminSwitch");
    const userSwitch = document.getElementById("userSwitch");
    const role = document.getElementById("role");

    adminSwitch.addEventListener("change", function() {
        if (this.checked) {
            userSwitch.checked = false;
            role.value = "admin";
        }
    });

    userSwitch.addEventListener("change", function() {
        if (this.checked) {
            adminSwitch.checked = false;
            role.value = "user";
        }
    });

    // Initialize Bootstrap Switch for toggle switches
    document.addEventListener("DOMContentLoaded", function() {
        const toggleSwitches = document.querySelectorAll('[data-toggle="toggle"]');
        toggleSwitches.forEach(function(switchElement) {
            new bootstrap.Switch(switchElement);
        });
    });

    // Age range validation
    const ageRangeInput = document.getElementById("age");
    const ageValueDisplay = document.getElementById("ageValue");
    const hiddenAgeInput = document.querySelector('input[name="uagevalue"]');
    ageRangeInput.addEventListener("input", function() {
        const selectedAge = this.value; // Get the selected age value from the range input
        ageValueDisplay.textContent = selectedAge; // Update the age value display
        hiddenAgeInput.value = selectedAge; // Update the hidden input field with the age value
    });
</script>

</html>
