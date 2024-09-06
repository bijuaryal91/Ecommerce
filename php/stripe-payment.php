<?php
session_start();
require_once '../includes/connect.php';

// Check user session
if (!isset($_SESSION['user_status']) || empty($_SESSION['user_status'])) {
    header('location: login.php');
    exit();
}

require_once('../stripe-php/init.php');

// Retrieve payment details
$total_amount = $_SESSION['amount'];
$dollar = $total_amount / 134; // Assuming this is the conversion rate
$order_id = $_SESSION['orderId'];

// Stripe API keys
$stripe = array(
    "SecretKey" => "sk_test_51PvxcyGWPrZNMW0vtera50FukRUKqzDiO3MgN1NYTuBjL8NAJNxXnOPGbOb9kR3yxG0MbLdf29NNozsyypEZlFuf00Voa2dZp8",
    "PublishableKey" => "pk_test_51PvxcyGWPrZNMW0vgCWBjPvtUaIzJkHkLCzcsSYVuDSyjapCCgzGLL8BEBcjVyTSnhV9xRKyVBzoU6usIcoQuCkP00kNCQSGOK"
);

// Set Stripe secret key
\Stripe\Stripe::setApiKey($stripe['SecretKey']);

// Retrieve the Stripe token from the POST request
$token = $_POST['stripeToken'] ?? null;
$statusMsg = '';

if ($token) {
    try {
        // Create a new Stripe customer
        $customer = \Stripe\Customer::create([
            'email' => $_SESSION['emailO'],
            'source' => $token,
            'name' => $_POST['cardholder-name'],
            'address' => [
                'line1' => 'Busparkroad',
                'postal_code' => '44100',
                'city' => 'Hetauda',
                'state' => 'Bagmati',
                'country' => 'Nepal',
            ],
            'description' => 'Jewelry Product Purchase',
        ]);

        // Charge the customer
        $charge = \Stripe\Charge::create([
            'customer' => $customer->id,
            'amount' => round($dollar * 100),  // Convert to cents
            'currency' => 'USD',
            'description' => 'Jewelry Product Purchase',
            'metadata' => ['order_id' => $order_id]
        ]);

        // Save transaction details in the database
        $transaction_id = uniqid('TXN-', true);
        $paymentsql = "INSERT INTO payments (order_id, payment_method, payment_status, transaction_id, amount) 
                       VALUES (?, 'stripe', 'paid', ?, ?)";

        // Prepare statement
        if ($stmt = mysqli_prepare($conn, $paymentsql)) {
            mysqli_stmt_bind_param($stmt, 'ssi', $order_id, $transaction_id, $total_amount);
            if (mysqli_stmt_execute($stmt)) {
                $statusMsg = 'Payment Successful!';
            } else {
                throw new Exception('Database error: ' . mysqli_error($conn));
            }
            mysqli_stmt_close($stmt);
        } else {
            throw new Exception('Database prepare error: ' . mysqli_error($conn));
        }
    } catch (Exception $e) {
        $statusMsg = 'Payment Failed: ' . $e->getMessage();
    }
} else {
    $statusMsg = 'Stripe token missing!';
}

// Display status message and redirect
echo "<script>alert('" . $statusMsg . "');</script>";
header("location: ../order-success.php");
exit();
