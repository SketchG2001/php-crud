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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="index.js"></script>
</head>
<style>
    .formError {
        color: red;
    }
</style>

<body>
    <?php
    // Check if there is any error message in the URL and display it
    if (isset($_GET['error'])) {
        $error_message = urldecode($_GET['error']);
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">' . $error_message .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }

    // Check if there is any success message in the URL and display it
    if (isset($_GET['message'])) {
        $success_message = urldecode($_GET['message']);
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $success_message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>



    <div class="mx-5">
        <form enctype="multipart/form-data" name="userInfo" action="adduser_server.php" onsubmit="return validateForm()" method="post">
            <div class="mb-3" id="firstname">
                <h3>Add New User</h3>
                <input type="text" name="fname" placeholder="First Name" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="lastname">
                <input type="text" name="lname" placeholder="Last Name" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="uname">
                <input type="text" name="username" placeholder="Username" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="email">
                <input type="text" name="femail" placeholder="Email" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="date">
                <label for="datefield" class="form-label">Date</label>
                <input type="date" name="date" class="form-control" id="datefield" min="1900-01-01" max="2024-12-31" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="mobile">
                <input type="tel" placeholder="Mobile" name="mobile" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="pass">
                <input type="password" name="password" value="username" placeholder="Password" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="mb-3" id="cpass">
                <input type="password" name="cpassword" value="username" placeholder="Confirm Password" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <input type="file" class="form-control" name="file" />
            <b><span class="formError"></span></b>
            <div class="mb-3 form-check">
                <input type="checkbox" name="update" value="1" class="form-check-input" id="checkbox" />
                <label class="form-check-label" for="checkbox">Did you want to receive updates</label>
            </div>
            <fieldset>
                <legend>Gender</legend>
                <div class="form-check mt-0 malediv">
                    <input class="form-check-input" type="radio" id="maleradio" name="gender" value="male" />
                    <label class="form-check-label" for="maleradio">Male</label>
                </div>

                <div class="form-check femalediv">
                    <input class="form-check-input" type="radio" id="femaleradio" name="gender" value="female" />
                    <label class="form-check-label" for="femaleradio">Female</label>
                </div>
            </fieldset>
            <span id="genderError" class="text-danger"></span>
            <input type="hidden" name="role" id="role" value="user">
            <div class="form-check form-switch mt-3">
                <input class="form-check-input" name="actype" type="checkbox" id="adminSwitch" aria-checked="false" />
                <label class="form-check-label" for="adminSwitch">Admin</label>
            </div>
            <div class="form-check form-switch mt-3">
                <input class="form-check-input" name="actype" type="checkbox" id="userSwitch" aria-checked="true" checked />
                <label class="form-check-label" for="userSwitch">User</label>
            </div>

            <span id="useradminError" class="text-danger"></span>
            <select class="form-select" name="skills" id="skills">
                <option value="non">Select your skill</option>
                <option value="html">html</option>
                <option value="css">css</option>
                <option value="javascript">javascript</option>
            </select>
            <div id="skillError" class="text-danger"></div>
            <div class="mb-3">
                <label for="age" class="form-label mt-3">your age</label>
                <input type="hidden" name="uagevalue" value="">
                <p id="ageValue"></p>
                <input style="width: 250px" type="range" name="age" class="form-range" min="15" max="100" id="age" /><br>
                <span id="ageError" style="display: inline;" class="text-danger"></span>
            </div>


            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    </div>
</body>
<script>
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


    document.addEventListener("DOMContentLoaded", function() {
        const toggleSwitches = document.querySelectorAll(
            '[data-toggle="toggle"]'
        );
        toggleSwitches.forEach(function(switchElement) {
            new bootstrap.Switch(switchElement);
        });
    });

    // age validation
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