<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['bicycleName'];
    $description = $_POST['bicycleDescription'];
    $price = $_POST['bicyclePrice'];
    $category = $_POST['bicycleCategory'];
    $stock = $_POST['bicycleStock'];

    // Handle file upload
    if (isset($_FILES['bicycleImage']) && $_FILES['bicycleImage']['error'] == 0) {
        $target_dir = "images/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["bicycleImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["bicycleImage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['error'] = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $_SESSION['error'] = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["bicycleImage"]["size"] > 500000) {
            $_SESSION['error'] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['error'] = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["bicycleImage"]["tmp_name"], $target_file)) {
                $image = basename($_FILES["bicycleImage"]["name"]); // Get the file name

                $sql = "INSERT INTO bicycles (name, description, price, category, image, stock) VALUES ('$name', '$description', '$price', '$category', '$image', '$stock')";

                if ($conn->query($sql) === TRUE) {
                    $_SESSION['message'] = "Bicycle added successfully!";
                    header("Location: sell.php");
                    exit;
                } else {
                    $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['error'] = "No file was uploaded or there was an error uploading the file.";
    }
}
header("Location: sell.php");
exit;
?>