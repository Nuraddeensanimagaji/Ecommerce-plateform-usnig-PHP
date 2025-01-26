<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location:   index.php"); // Redirect to the index.php file in the users folder
            exit;
        } else {
            $_SESSION['error'] = "Invalid password.";
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cycle-Connect</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <section class="auth-form">
        <h2>Login</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <p style="text-align:center">Don't have an account? <a href="register.php">Register here</a></p>
        </form>
    </section>
</body>
</html>