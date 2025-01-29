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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css"> <!-- Link to your custom styles -->
    <style>
        body {
            background: rgba(0, 0, 0, 0.5); /* Transparent dark background */
            backdrop-filter: blur(10px); /* Add blur effect */
            font-family: Arial, sans-serif;
        }

        .auth-form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .auth-form label {
            font-weight: bold;
        }

        .auth-form input {
            margin-bottom: 15px;
        }

        .auth-form button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background: linear-gradient(to right, #007bff, #00c6ff);
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }

        .auth-form button:hover {
            background-color: #FF4500; /* Darker orange on hover */
        }

        .auth-form p {
            text-align: center;
            font-size: 14px;
        }

        .auth-form a {
            color: #FF5733;
        }
    </style>
</head>
<body>

    <section class="auth-form">
        <!-- Display session error if any -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <h3 class="text-center mb-4">Register</h3>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" class="form-control" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" class="form-control" required>

            <p>Already have an account? <a href="login.php">Login here</a></p>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
