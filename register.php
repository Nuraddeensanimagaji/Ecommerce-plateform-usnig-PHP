<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Registration successful! You can now log in.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cycle-Connect</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <section class="auth-form">
        <h2>Register</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Register</button>
            <p style="text-align:center">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </section>
</body>
</html>