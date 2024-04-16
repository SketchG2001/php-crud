<?php
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

include("config.php");

$username = $_SESSION["username"];
$sql = "SELECT * FROM `userDB` WHERE username='$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $image = $row["file"];
    }
}

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File upload logic
    if (isset($_FILES['file']) && $_FILES['file']['size'] > 0) {
        $file = $_FILES['file'];
        $filename = $_FILES['file']['name'];
        $fileTMPName = $_FILES['file']['tmp_name'];
        $filesize = $_FILES['file']['size'];
        $fileerror = $_FILES['file']['error'];
        $filetype = $_FILES['file']['type'];

        $fileExt = explode('.', $filename);
        $fileactualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileactualExt, $allowed)) {
            if ($fileerror === 0) {
                if ($filesize < 1000000) {
                    $fileNamenew = uniqid('', true) . "." . $fileactualExt;
                    $fileDestination = 'uploads/' . $fileNamenew;
                    move_uploaded_file($fileTMPName, $fileDestination);

                    // Update user information
                    $stmt = $conn->prepare("UPDATE userDB SET file=? WHERE username=?");
                    $stmt->bind_param('ss', $fileDestination, $username);

                    if ($stmt->execute()) {
                        $success_message = "File updated successfully.";
                        header("Location: welcome.php");
                    } else {
                        $error_message = "Error updating file.";
                    }
                } else {
                    $error_message = 'File size is too large.';
                }
            } else {
                $error_message = "There was an error uploading the file.";
            }
        } else {
            $error_message = "Invalid file format. Allowed formats are JPG, JPEG, PNG, and PDF.";
        }
    } else {
        // No file uploaded
        $error_message = "No file uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h3>Change your Profile</h3>
        <hr>
        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form action="chnageprofile.php" name="userInfo" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="file" class="form-control" name="file" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        <?php echo '<img src="' . $image . '" alt="User Image" class="mt-3" style="width: 200px; height: 200px;">'; ?>
    </div>
</body>

</html>
