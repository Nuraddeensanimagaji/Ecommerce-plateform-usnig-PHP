<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy & Sell Bicycles</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Custom Styles */
        .hero {
            background: linear-gradient(to right, #007bff, #00c6ff);
            color: white;
        }
        .hero .btn {
            transition: transform 0.3s ease-in-out;
        }
        .hero .btn:hover {
            transform: scale(1.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .footer {
            background: #343a40;
            color: white;
        }
        .dark-mode {
            background-color: #222;
            color: white;
        }
        .dark-mode .navbar, .dark-mode .footer {
            background-color: black;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Cycle-Connect </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="product.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="sell.php">Sell Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_login.php" id="adminLink">Admin</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><button class="btn btn-outline-light ms-2" id="darkModeToggle">🌙 Dark Mode</button></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <section class="hero text-center py-5">
        <div class="container">
            <h2 class="display-4">Welcome to Cycle-Connect! 🚲</h2>
            <p class="lead">Your one-stop destination for buying and selling bicycles!</p>
            <a href="product.php" class="btn btn-warning btn-lg">🚀 Browse Products</a>
        </div>
    </section>
    <pre>










    
    </pre>
    
    <footer class="footer text-center py-3">
        <p class="mb-0">&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark Mode Toggle
        document.getElementById("darkModeToggle").addEventListener("click", function() {
            document.body.classList.toggle("dark-mode");
        });
    </script>
</body>
</html>
