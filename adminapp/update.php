<?php
session_start();
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (!isset($_SESSION['username'])) {
    header('Location login.php');
    exit();
}
include 'config.php';
$username = $_GET['username'];
$sql = "SELECT * FROM `userDB` WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userid = $row['id'];
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $username = $row['username'];
        $gender = $row['gender'];
        $password = $row['password'];
        $dob = $row['dob'];
        $role = $row['role'];
        $skill = $row['skills'];
        $age = $row['age'];
        $updates = $row['updates'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $image = $row['file'];

        // if (substr($image, 0, 6) === "../../") {
        //     // If it does, remove "../../" and get the rest of the path
        //     $image = substr($image, 3); // Remove the first three characters
        // }
        
    }
}
// echo $image;
// die();
//else {
//     echo "erro to redirect update";
// }
// echo"$firstname"."<br>";
// echo"$lastname"."<br>";
// echo"$username"."<br>";
// echo"$email"."<br>";
// echo"$mobile"."<br>";
// echo"$image"."<br>";
// exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="updateValidation.js"></script>
    <style>
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

  .container {
      /* width: 50%; */
  }


  /* Custom CSS */
  .form-range {
    width: 100%;
    /* Makes the range input fill the entire width of its container */
    margin-top: 10px;
    /* Adds some space between the range input and the error message */
    border: 2px solid red;
    border-radius: 20px;
  }

  .form-group p {
    margin-top: 5px;
    /* Adds some space between the range input and the paragraph */
  }

  /* Custom CSS */
  .btn-primary {
    background-color: #007bff;
    /* Blue */
    border-color: #007bff;
    /* Blue */

  }

  .btn-primary:hover {
    background-color: #0056b3;
    /* Darker blue */
    border-color: #0056b3;
    /* Darker blue */
  }

  .btn-primary:focus,
  .btn-primary.focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
    /* Blue with opacity */
  }

  .btn-lg {
    padding: 10px 30px;
    /* Large padding */
    font-size: 1.25rem;
    /* Larger font size */
    width: 35%;
    border-radius: 30px;
  }

  .mt-3 {
    margin-top: 15px;
    /* Margin top 15px */
  }

  /* Custom CSS */
  .formError {
    color: red;
    /* Set text color to red */
    font-size: 14px;
    /* Set font size */
    font-weight: bold;
    /* Set font weight to bold */
    /* Add any additional styling here */
  }




  #serror {
    display: flex;
   justify-content: center;
    align-items: center;
  
   } 
    .error-container {
    display: block;
   }




        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .popup-content {
            text-align: center;
        }

        .popup button {
            margin: 0 10px;
        }
    </style>

</head>

<body>
    <?php if (isset($_GET['error'])) {
        $error_message = $_GET['error'];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Error: </strong>' .
            '' .
            $error_message .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    } ?>
    <div class="container form-control">
    <div class="text-center">
      <img class="profile" src="../assets/newac.svg" alt="">
      <h3 class="heading">Update User Details Here</h3>
    </div>
        <form enctype="multipart/form-data" id="myForm" name="userInfo" action="update_server.php" method="post">
            <div class="form-group col my-3" id="firstname">
                <label for="cpassword" class="form-label">First Name</label>
                <input type="text" value="<?php echo $firstname; ?>" name="fname" placeholder="First Name" class="form-control" />
                <b><span class="formError"></span></b>
            </div>

            <div class="form-group col my-3" id="lastname">
                <label for="cpassword" class="form-label">Last Name</label>
                <input type="text" name="lname" value="<?php echo $lastname; ?>" placeholder="Last Name" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="form-group col my-3" id="uname">
                <label for="cpassword" class="form-label">Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="form-group col my-3" id="email">
                <label for="cpassword" class="form-label">Email Address</label>
                <input ty pe="text" name="femail" value="<?php echo $email; ?>" placeholder="Email" class="form-control" />
                <b><span class="formError"></span></b>
            </div>
            <div class="form-group col my-3" id="pass">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" placeholder="Password" class="form-control" />
                <b><span class="formError" style="color: red;"></span></b>
            </div>
            <div class="form-group col my-3" id="cpass">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" />
                <b><span class="formError" style="color: red;"></span></b>
            </div>
            <div class="form-group col my-3">
                <input type="file" class="form-control" name="file" />
                <?php echo '<img src="' .$image .
                    '" alt="User Image" class="mt-1" style="width: 200px; height: 200px;">'; ?>
            </div>
            <div class="form-group col my-3" id="date ">
                <label for="datefield" class="form-label">Date</label>
                <input type="date" name="date" value="<?php echo $dob; ?>" class="form-control" id="datefield" min="1900-01-01" max="2024-12-31" />
                <b><span class="formError"></span></b>
            </div>
            <div class="form-group col my-3" id="mobile">
                <label for="cpassword" class="form-label">Mobile number</label>
                <input type="tel" placeholder="Mobile" value="<?php echo $mobile; ?>" name="mobile" class="form-control" />
                <b><span class="formError"></span></b>
            </div>

            <div class="form-group col mt-3" id="serror">
     
     <select class="form-group col my-3 form-select" name="skills" id="skills">
     <?php
     // Array of skills options
     $skills = ['html', 'css', 'javascript'];

     // Loop through each skill option
     foreach ($skills as $skillOption) {
         // Check if the current skill option matches the selected skill from the database ($skill)
         $selected = $skillOption === $skill ? 'selected' : '';

         // Output the option tag
         echo '<option value="' .
             $skillOption .
             '" ' .
             $selected .
             '>' .
             ucfirst($skillOption) .
             '</option>';
     }
     ?>
     </select><br>
     <div class="error-container">
     <div id="skillError" class="text-danger"></div>
     </div>
   </div>

            <div class="form-group col my-3 form-check">
                <input type="checkbox" name="update" value="<?php echo $updates; ?>" class="form-check-input" id="checkbox" />
                <label class="form-check-label" for="checkbox">Did you want to receive updates</label>
            </div>

            <div class="form-group col my-3">
        <div class="container">
          <label for="datefield" class="form-label">Gender</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="maleradio" name="gender" value="male" <?php echo $gender ===
            'Male'
                ? 'checked'
                : ''; ?> />
            <label class="form-check-label" for="maleradio">Male</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" id="femaleradio" name="gender" value="female" <?php echo $gender ===
            'female'
                ? 'checked'
                : ''; ?> />
            <label class="form-check-label" for="femaleradio">Female</label>
          </div>
        </div>
        <span id="genderError" class="text-danger"></span>
      </div>
      <input type="hidden" name="role" id="role" value="user">

<div class="form-check form-switch my-3 form-group col">
  <label class="form-label  " for="accountType">Account Type</label>
  <div class="form-check form-switch-inline">
    <input class="form-check-input" name="actype" type="checkbox" id="adminSwitch" aria-checked="false" <?php echo $role ===
    'admin'
        ? 'checked'
        : ''; ?> />
    <label class="form-check-label" for="adminSwitch">Admin</label>
  </div>
  <div class="form-check form-switch-inline">
    <input class="form-check-input" name="actype" type="checkbox" id="userSwitch" aria-checked="true" <?php echo $role ===
    'user'
        ? 'checked'
        : ''; ?>  />
    <label class="form-check-label" for="userSwitch">User</label>
  </div>
</div>

            <div class="form-group col my-3">
                <label for="age" class="form-label mt-3">your age</label>
                <input type="hidden" name="uagevalue" value="">
                <p id="ageValue"><?php echo $age; ?></p>
                <input style="width: 250px" type="range" name="age" class="form-range text-center" min="15" max="100" id="age" /><br>
                <span id="ageError" style="display: inline;" class="formError"></span>
            </div>
            <div class="container text-center">
            <button type="submit" name="submit" onclick="return validateFormAndConfirm()" value="userInfo" class="btn btn-primary btn-lg mt-3">Submit</button>
            <button type="submit" id="submitBtn" name="submit" value="userInfo" class="btn btn-primary" style="display: none;">Submit</button>
            </div>
           

        </form>
    </div>
    </div>
    <div class="popup toast" id="confirmationPopup">
    <div class="popup-content">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p>Are you sure you want to submit the form?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Yes</button>
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">No</button>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Your HTML code -->

    <script>
        // Function to display the popup
        function displayPopup() {
            document.getElementById('confirmationPopup').style.display = 'block';
        }

        // Function to close the popup
        function closePopup() {
            document.getElementById('confirmationPopup').style.display = 'none';
        }

        // Function to validate form and confirm submission
        function validateFormAndConfirm() {
            if (validateForm()) { // Assuming you have a validateForm function
                displayPopup();
                return false; // Prevents the form from submitting automatically
            }
            return false; // Prevents the form from submitting automatically if validation fails
        }

        // Function to submit the form
        function submitForm() {
            // Programmatically trigger click event on the submit button
            document.getElementById('submitBtn').click();
        }
    </script>


    <!-- Your HTML code continues... -->


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