<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<style>
  label {
    text-align: center;
    /* display: block; */
    margin-left: 10px;
    margin-top: 2%;
    font-size: 16px;
    font-weight: bold;
    color: #847CFE;
    font-size: 25px;
  }

  #username {
    width: 100%;
    margin: auto;
    background-color: transparent;
    border: 2px solid blue;
    border-radius: 20px;
  }

  #password {
    width: 100%;
    margin: auto;
    background-color: transparent;
    border: 2px solid blue;
    border-radius: 20px;
  }

  .formdiv1 {

    width: 100%;
    text-align: center;
    opacity: 1;
  }

  .formdiv {
    display: inline-block;
    text-align: left;
    border: 2px;
    border-radius: 35px;
    width: 40%;
    margin: 0 auto;
    margin-top: 100px;
    position: relative;
    padding: 50px;
  }

  .formdiv::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    z-index: -1;

  }

  body {
    background-image: url(../assets/bodybc.jpg);
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    border-radius: 10px;
    z-index: -1;
  }

  .prfile {
    height: 110px;
    width: 100px;
    /* border: 2px solid #A521FD; */
    /* border-radius: 50%; */
    margin-left: 38%;
  }



  .formbutton {
    margin-left: auto;
    display: block;
    text-align: center;

  }

  h3 {
    margin: auto;
    display: block;
    text-align: center;
    color: #A521FD;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
  }

  .admin {
    margin-right: 46px;
  }

  .login {
    width: 100%;
    border-radius: 30px;
  }

  .Sign {
    width: 100%;
    margin-top: 5px;
    border-radius: 50px;
  }

  .dont {
    text-align: left;
    margin: auto;
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
          <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
          <a class="nav-link active" href="../login.php">User Login</a>
          <a class="nav-link active" href="adminapp/admin.php">Admin Login</a>
          <a class="nav-link active" href="../newregister.php">Register Here</a>
        </div>
      </div>
    </div>
  </nav>
  <?php
  // Check if there is an error message in the URL parameters
  if (isset($_GET['error'])) {
    // Decode the error message from URL and store it in a variable
    $error_message = urldecode($_GET['error']);
    // Display the error message in an alert box
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              ' . $error_message . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }

  // Check if there is a success message in the URL parameters
  if (isset($_GET['message'])) {
    // Decode the success message from URL and store it in a variable
    $success_message = urldecode($_GET['message']);
    // Display the success message in an alert box
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              ' . $success_message . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
  if (isset($_GET['success'])) {
    // Decode the success message from URL and store it in a variable
    $success_message = urldecode($_GET['success']);
    // Display the success message in an alert box
    echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
              ' . $success_message . '
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
  }
  ?>




  <div class="formdiv1">
    <div class="mx-5 formdiv container">
      <img class="prfile" src="../assets/adminsvg.svg" alt="">
      <h3>Admin Login</h3>
      <form method="post" action="adminlogin.php" name="login">
        <div class="mb-3" id="uname">
          <label for="username" class="form-label">Username</label>
          <input type="text" placeholder="username" name="username" class="form-control" id="username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" placeholder="password" name="password" class="form-control" id="password">
        </div>
        <div class="formbutton">
          <span><button type="submit" class="btn btn-primary login">Login</button></span>
          <span>
            <p class="mt-2 dont">Don't have account?</p>
          </span>

          <span><a href="../newregister.php" class="btn btn-primary Sign">Sign Up</a></span><br>
          <span class="fpass"><a href="../forgetpassword.php">forget Password</a></span><br>
        </div>

      </form>
    </div>
  </div>
</body>

</html>