<?php
include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $username = $_POST["username"];
    $newpass = $_POST["password"];
    $newcpass = $_POST["cpassword"];

    if ($newpass != $newcpass) {
        $error_message = "The given passwords don't match.";
    } else {
        $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT password FROM userDB WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $current_password = $row["password"];

            if (!password_verify($newpass, $current_password)) {
                $update_stmt = $conn->prepare("UPDATE userDB SET password = ? WHERE username = ?");
                $update_stmt->bind_param("ss", $hashed_password, $username);
                if ($update_stmt->execute()) {
                    $successmsg = "Password updated successfully.";
                } else {
                    $error_message = "Error updating password: " . $conn->error;
                }
                $update_stmt->close();
            } else {
                $error_message = "New password is the same as the current password.";
            }
        } else {
            $error_message = "User not found.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
<?php if (!empty($error_message)) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error_message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (!empty($successmsg)) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $successmsg; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


    <div class="container mt-3">
        <h3>Change your Password</h3>
        <hr>
        <form action="forgetpassword.php" name="userInfo" onsubmit="return validateForm()" method="post">
            <div class="mb-3" id="uname">
                <label for="username" class="form-label">Username</label>
                <input id="username" type="text" name="username" placeholder="Username" class="form-control" />
                <b><span class="formError" style="color: red;"></span></b>
            </div>
            <div class="mb-3" id="pass">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" name="password" placeholder="Password" class="form-control" />
                <b><span class="formError" style="color: red;"></span></b>
            </div>
            <div class="mb-3" id="cpass">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" name="cpassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" />
                <b><span class="formError" style="color: red;"></span></b>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <script>
        function clearError() {
            const errors = document.getElementsByClassName("formError");
            for (let err of errors) {
                err.textContent = "";
            }
        }

        function setError(id, error) {
            const element = document.getElementById(id);
            const errorElement = element.querySelector(".formError");
            if (errorElement) {
                errorElement.textContent = error;
            }
        }

        function validateForm() {
            clearError();

            const username = document.forms["userInfo"]["username"].value.trim();
            const usernameRegex = /^[0-9a-zA-Z]+$/;
            if (!usernameRegex.test(username)) {
                setError("uname", "Username is invalid.");
                return false;
            }

            const password = document.forms["userInfo"]["password"].value.trim();
            const confirmPassword = document.forms["userInfo"]["cpassword"].value.trim();

            if (password.length === 0 || confirmPassword.length === 0) {
                setError("cpass", "Password must be filled out.");
                return false;
            }

            if (password !== confirmPassword) {
                setError("cpass", "Passwords do not match.");
                return false;
            }

            const commonPassword = ["password", "123456", "qwerty", "letmein", username.toLowerCase()];
            if (commonPassword.includes(password.toLowerCase())) {
                setError("pass", "Password should be unique.");
                return false;
            }
        }
    </script>
</body>

</html>
