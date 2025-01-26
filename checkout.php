<?php
session_start();
require 'config.php'; // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$product_ids = array_keys($_SESSION['cart']);
if (count($product_ids) > 0) {
    $ids = implode(',', $product_ids);
    $sql = "SELECT * FROM bicycles WHERE id IN ($ids)";
    $result = $conn->query($sql);
    $products = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $products = array();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cycle-Connect</title>
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

    <!-- Checkout Section -->
    <section class="checkout">
        <h2>Checkout</h2>
        <?php if (count($products) > 0): ?>
            <form method="POST" action="process_checkout.php">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select id="payment_method" name="payment_method" required>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <h3>Order Summary</h3>
                <ul>
                    <?php foreach ($products as $product): ?>
                        <li><?php echo $product['name']; ?> - ₦<?php echo $product['price']; ?> x <?php echo $_SESSION['cart'][$product['id']]; ?></li>
                    <?php endforeach; ?>
                </ul>
                <h3>Total: ₦<?php echo array_sum(array_map(function($product) {
                    return $product['price'] * $_SESSION['cart'][$product['id']];
                }, $products)); ?></h3>
                <button type="submit">Place Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>