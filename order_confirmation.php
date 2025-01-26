<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Cycle-Connect</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <h1>Cycle-Connect</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Products</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <!-- Order Confirmation Section -->
    <section class="order-confirmation">
        <h2>Order Confirmation</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <p><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php else: ?>
            <p>No order has been placed.</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>