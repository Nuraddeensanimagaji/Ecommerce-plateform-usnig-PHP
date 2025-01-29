<?php
session_start();
require 'config.php'; // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_amount = $_SESSION['order_details']['total_amount'];
    $order_id = $_SESSION['order_details']['order_id'];

    // PayPal configuration
    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $paypal_id = 'your_paypal_business_email@example.com'; // Business email

    echo '<form action="' . $paypal_url . '" method="post" name="frmPayPal1">
        <input type="hidden" name="business" value="' . $paypal_id . '">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="item_name" value="Order ' . $order_id . '">
        <input type="hidden" name="item_number" value="' . $order_id . '">
        <input type="hidden" name="amount" value="' . $total_amount . '">
        <input type="hidden" name="currency_code" value="USD">
        <input type="hidden" name="return" value="http://yourwebsite.com/success.php">
        <input type="hidden" name="cancel_return" value="http://yourwebsite.com/cancel.php">
        <input type="submit" value="Pay Now">
    </form>';
}
?>