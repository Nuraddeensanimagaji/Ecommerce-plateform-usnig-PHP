<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    // Fetch cart items
    $product_ids = array_keys($_SESSION['cart']);
    $products = [];
    if (count($product_ids) > 0) {
        $ids = implode(',', $product_ids);
        $sql = "SELECT * FROM products WHERE id IN ($ids)";
        $result = $conn->query($sql);
        if ($result) {
            $products = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            echo "<p>Error fetching products: " . $conn->error . "</p>";
            exit;
        }
    }

    // Create a map of product IDs to ensure they exist
    $product_map = [];
    foreach ($products as $product) {
        $product_map[$product['id']] = $product;
    }

    // Check if all products in the cart exist in the database
    foreach ($product_ids as $product_id) {
        if (!isset($product_map[$product_id])) {
            echo "<p>Error: Product ID $product_id does not exist.</p>";
            exit;
        }
    }

    // Calculate total amount
    $total_amount = 0;
    foreach ($product_map as $product_id => $product) {
        $total_amount += $product['price'] * $_SESSION['cart'][$product_id];
    }

    // Insert order into the orders table
    $sql = "INSERT INTO orders (user_id, name, address, payment_method, total_amount) VALUES ('$user_id', '$name', '$address', '$payment_method', '$total_amount')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert order items into the order_items table
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
            if (!$conn->query($sql)) {
                echo "<p>Error inserting order item: " . $conn->error . "</p>";
                exit;
            }
        }

        // Clear the cart
        unset($_SESSION['cart']);

        // Display success message
        echo "<p>Order placed successfully!</p>";
        exit;
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}
header("Location: checkout.php");
exit;
?>