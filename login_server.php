<?php
session_start();

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if username is empty
    if (empty($username)) {
        $error_message = "Username is required to access";
        header("Location: login.php?error=".urlencode($error_message));
        exit();
    }
    // Check if username contains a number
    elseif (!(preg_match("/[0-9]/", $_POST["username"]))) {
        $error_message = "Username must contain a number";
        header("Location: login.php?error=".urlencode($error_message));
        exit();  
    }
    // Check if password is empty
    if (empty($password)) {
        $error_message = "Password is required to access";
        header("Location: login.php?error=".urlencode($error_message));
        exit();
    }
    else {
        // Prepare SQL statement to check for user
        $stmt = $conn->prepare("SELECT id, username, password FROM userDB WHERE username=?");
        
        // Check if prepare was successful
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // User found, verify password
            $row = $result->fetch_assoc();
            $hashed_password = $row["password"];
            
            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session and redirect to dashboard
                $_SESSION["username"] = $username;
                header("Location: welcome.php");
                exit(); // Stop further execution
            } else {
                $error_message = "Incorrect password";
                header("Location: login.php?message=".urlencode($error_message));
                exit();
            }
        } else {
            $error_message = "User not found";
            header("Location: login.php?message=".urlencode($error_message));
            exit();
        }

        $stmt->close(); // Close the prepared statement
    }
}
?>
