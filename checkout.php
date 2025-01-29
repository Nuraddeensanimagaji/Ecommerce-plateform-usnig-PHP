<?php
session_start();
require 'config.php'; // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the cart is empty
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

// Fetch cart items for the logged-in user
$product_ids = array_keys($_SESSION['cart']);
$products = [];
if (count($product_ids) > 0) {
    $ids = implode(',', $product_ids);
    $sql = "SELECT * FROM bicycles WHERE id IN ($ids)";
    $result = $conn->query($sql);
    if ($result) {
        $products = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        echo "<p>Error fetching products: " . $conn->error . "</p>";
        exit;
    }
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
                <li><a href="checkout.php">Checkout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Checkout Section -->
    <section class="checkout">
<pre>
    
</pre>
        <form action="process_checkout.php" method="post">
            <h3>Shipping Information</h3>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <label for="payment_method">Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cod">Cash on Delivery</option>
            </select>
            <h3>Order Summary</h3>
            <ul>
                <?php foreach ($products as $product): ?>
                    <li><?php echo $product['name']; ?> - ₦<?php echo $product['price']; ?> x <?php echo $_SESSION['cart'][$product['id']]; ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="submit">Place Order</button>
        </form>
    </section>
<pre>






</pre>
    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>