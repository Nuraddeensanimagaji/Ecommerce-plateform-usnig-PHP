<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);
    $total_amount = array_sum(array_map(function($product) {
        return $product['price'] * $_SESSION['cart'][$product['id']];
    }, $_SESSION['cart']));

    // Insert order into the orders table
    $sql = "INSERT INTO orders (user_id, name, address, payment_method, total_amount) VALUES ('$user_id', '$name', '$address', '$payment_method', '$total_amount')";
    if ($conn->query($sql) === TRUE) {
        $order_id = $conn->insert_id;

        // Insert order items into the order_items table
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
            $conn->query($sql);
        }

        // Clear the cart
        unset($_SESSION['cart']);

        $_SESSION['message'] = "Your order has been placed successfully!";
        header("Location: order_confirmation.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}
header("Location: checkout.php");
exit;
?>