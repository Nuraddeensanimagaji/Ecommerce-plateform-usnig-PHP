<?php
session_start();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding items to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $product_id = $_POST['product_id'];
    //  $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
       // $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
}

// Handle removing items from the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'remove') {
    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
}

// Handle updating item quantities
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'update') {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $_SESSION['cart'][$product_id] = $quantity;
}

// Fetch products from the database
$servername = "localhost";
$username = "root";
$password = "@Kangire1084";
$dbname = "bicycle";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$product_ids = array_keys($_SESSION['cart']);
if (count($product_ids) > 0) {
    $ids = implode(',', $product_ids);
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
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
    <title>Shopping Cart - Cycle-Connect</title>
    <link rel="stylesheet" href="style /style.css">
    <link rel="stylesheet" href="style/cart.css">
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

    <!-- Shopping Cart -->
    <section class="cart">
        <h2>Your Shopping Cart</h2>
        <?php if (count($products) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>₦<?php echo $product['price']; ?></td>
                            <td>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $_SESSION['cart'][$product['id']]; ?>" min="1">
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                            <td>₦<?php echo $product['price'] * $_SESSION['cart'][$product['id']]; ?></td>
                            <td>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-total">
                <h3>Total: ₦<?php echo array_sum(array_map(function($product) {
                    return $product['price'] * $_SESSION['cart'][$product['id']];
                }, $products)); ?></h3>
            </div>
            <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
     <pre>



            







     
     </pre>
    <footer>
        <p>&copy; 2025 Cycle-Connect. All rights reserved.</p>
    </footer>
</body>
</html>