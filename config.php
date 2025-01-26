<?php
$servername = "localhost";
$username = "root";
$password = "@Kangire1084";
$dbname = "bicycle";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>