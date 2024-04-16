<?php

// echo "hello";
// exit;
session_start();

include("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // echo"$username";
    // echo"$password";
    // exit();




    if (empty($username)) {
        $error_message = "username is required to access";
        header("Location: admin.php?error=" . urlencode($error_message));
        exit();
    } elseif (!(preg_match("/[0-9]/", $_POST["username"]))) {
        $error_message = "username must contains a number";
        header("Location: admin.php?error=" . urlencode($error_message));
        exit();
    }
    if (empty($password)) {
        $error_message = "password is required to access";
        header("Location: admin.php?error=" . urlencode($error_message));
        exit();
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role FROM userDB WHERE username=?");

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
            $role = $row["role"];
            // echo $role; // Echoing the role for debugging purposes
            // exit();

            if (password_verify($password, $hashed_password)) {
                // Password is correct, set session and redirect to dashboard
                if ($role === "admin") {
                    $_SESSION["username"] = $username;
                    header("Location: adminDashboard.php");
                    exit();
                }else{
                    $message = "you are not authorized perosn please login as user.";
                    header("Location: ../login.php?error=".urlencode($message));
                    exit(); 
                }
                // Stop further execution after successful login
            } else {
                // Password is incorrect
                echo "Incorrect password"; // For debugging purposes, you might want to handle this differently in production
            }
        } else {
            // Username not found
            echo "Username not found"; // For debugging purposes, you might want to handle this differently in production
        }
    }
}
