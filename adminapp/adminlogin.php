<?php
// Start session
session_start();

// Include database configuration
include("config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate username
    if (empty($username)) {
        $errorMessage = "Username is required to access";
        header("Location: admin.php?error=" . urlencode($errorMessage));
        exit();
    } elseif (!(preg_match("/[0-9]/", $_POST["username"]))) {
        $errorMessage = "Username must contain a number";
        header("Location: admin.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Validate password
    if (empty($password)) {
        $errorMessage = "Password is required to access";
        header("Location: admin.php?error=" . urlencode($errorMessage));
        exit();
    } else {
        // Prepare SQL statement to fetch user details
        $stmt = $conn->prepare("SELECT id, username, password, role FROM userDB WHERE username=?");

        // Check if prepare was successful
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        // Bind parameters and execute query
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            // User found, verify password
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password"];
            $role = $row["role"];

            // Verify password
            if (password_verify($password, $hashedPassword)) {
                // Password is correct, set session and redirect to dashboard
                if ($role === "admin") {
                    $_SESSION["username"] = $username;
                    header("Location: adminDashboard.php");
                    exit();
                } else {
                    // Redirect with error message for unauthorized person
                    $errorMessage = "You are not an authorized person. Please login as a user.";
                    header("Location: ../login.php?error=" . urlencode($errorMessage));
                    exit();
                }
            } else {
                // Password is incorrect
                echo "Incorrect password"; // For debugging purposes
            }
        } else {
            // Username not found
            echo "Username not found"; // For debugging purposes
        }
    }
}
?>
