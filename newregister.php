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
</style>




<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
          <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
          <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
        </svg></i></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="index.html">Home</a>
          <a class="nav-link active" href="login.php">User Login</a>
          <a class="nav-link active" href="adminapp/admin.php">Admin Login</a>
          <a class="nav-link active" href="newregister.php">Register Here</a>
        </div>
      </div>
    </div>
  </nav>

  <div class="container form-control">
    <div class="text-center">
      <img class="profile" src="assets/newac.svg" alt="">
      <h3 class="heading">Register Here</h3>
    </div>
    <form enctype="multipart/form-data" name="userInfo" action="register.php" onsubmit="return validateForm()" method="post">
      <div class=" form-group col my-3" id="firstname">
        <label for="fname" class="form-label">First Name</label>
        <input type="text" id="fname" name="fname" placeholder="First Name" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class=" form-group col my-3" id="lastname">
        <label for="lname" class="form-label">Last Name</label>
        <input type="text" id="lname" name="lname" placeholder="Last Name" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class=" form-group col my-3" id="uname">
        <label for="username" class="form-label">Username</label>
        <input type="text" id="username" name="username" placeholder="Username" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class=" form-group col my-3" id="email">
        <label for="femail" class="form-label">Email</label>
        <input type="text" id="femail" name="femail" placeholder="Email" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class=" form-group col my-3" id="date">
        <label for="date" class="form-label">Date</label>
        <input type="date" id="date" name="date" class="form-control" id="datefield" min="1900-01-01" max="2024-12-31" />
        <b><span class="formError"></span></b>
      </div>
      <div class=" form-group col my-3" id="mobile">
        <label for="mobile" class="form-label">Mobile</label>
        <input type="tel" id="mobile" placeholder="Mobile" name="mobile" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class="form-group col form-group col my-3" id="pass">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class=" form-group col my-3" id="cpass">
        <label for="cpassword" class="form-label">Confirm Password</label>
        <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" class="form-control" />
        <b><span class="formError"></span></b>
      </div>
      <div class="form-group col mt-3" id="serror">
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

      <div id="skillError" class=" text-danger"></div>
      <div class="form-group col my-3 file" id="image">
        <label for="file" class="form-label">Latest Photo</label>
        <input type="file" id="file" class="form-control" name="file" accept="image/png, image/gif, image/jpeg" />
        <b><span class="formError"></span></b>
      </div>
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
      <div class=" form-group my-3 col form-check">
        <input type="checkbox" name="update" value="1" class="form-check-input" id="checkbox" />
        <label class="form-check-label" for="checkbox">Did you want to receive updates</label>
      </div>

      <input type="hidden" name="role" id="role" value="user">

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


      <span id="useradminError" class="text-danger"></span>

      <div class="form-group col my-3">
        <label for="age" class="form-label my-2">Your Age</label>
        <input type="hidden" name="uagevalue" value="">
        <p id="ageValue"></p>
        <input style="width: 250px" type="range" name="age" class="form-range" min="15" max="100" id="age" />
        <br>
        <span id="ageError" style="display: inline;" class="text-danger"></span>
      </div>

      <div class="container text-center">
        <button type="submit" name="submit" class="btn btn-primary btn-lg mt-3">Submit</button>
      </div>
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