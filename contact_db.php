<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Your message has been sent successfully!";
        header("Location: contact.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}
header("Location: contact.php");
exit;
?>