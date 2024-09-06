<?php
session_start();
include_once("../includes/connect.php");

// Check if the user is logged in
if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sqllala = "SELECT * FROM users WHERE user_id=" . $user_id;
$rowlalala = mysqli_fetch_assoc(mysqli_query($conn, $sqllala));

// Retrieve form data
$name = $_POST['name'];
$name_parts = explode(' ', $name, 2); // Explode by space, limit to 2 parts
$fname = $name_parts[0]; // First name
$lname = isset($name_parts[1]) ? $name_parts[1] : ''; // Last name, if it exists
$email = $rowlalala['email'];
$address = $_POST['address'];
$street = $_POST['street'];
$apartment = $_POST['apart'] ?? '';
$city = $_POST['town'];
$phone = $_POST['phone'];
$saveInfo = isset($_POST['saveData']) ? true : false;  // Checkbox value
$payment_method = $_POST['payment_method'];
$tracking_number = generateTrackingNumber();
$discountlalaal = $_POST['discountedPrice'];

// If "Save Information for later" is checked, store the information in the database
if ($saveInfo) {
    $update_user_sql = "UPDATE users SET 
                            first_name='$fname',
                            last_name='$lname',
                            address = '$address',
                            street = '$street',
                            apartment = '$apartment',
                            city = '$city',
                            phone_number = '$phone'
                        WHERE user_id = '$user_id'";

    $update_result = mysqli_query($conn, $update_user_sql);

    if (!$update_result) {
        // Handle the error if the query fails
        echo "Failed to save billing information: " . mysqli_error($conn);
        exit();
    }
}

// Check stock availability before placing the order
$stock_available = true; // Flag to track stock availability
$cart_items = []; // Array to hold cart items for later processing

$cart_sql = "SELECT ci.product_id, ci.quantity, p.price, p.stock_quantity,p.name
             FROM cart_items ci 
             JOIN products p ON ci.product_id = p.product_id 
             WHERE ci.cart_id = (SELECT cart_id FROM carts WHERE user_id = '$user_id')";

$cart_result = mysqli_query($conn, $cart_sql);

while ($cart_item = mysqli_fetch_assoc($cart_result)) {
    $product_id = $cart_item['product_id'];
    $product_name = $cart_item['name'];
    $quantity = $cart_item['quantity'];
    $price = $cart_item['price'];
    $stock_quantity = $cart_item['stock_quantity'];

    // Check if the requested quantity is available
    if ($quantity > $stock_quantity) {
        echo "Low Stock: ".$product_name;
        $stock_available = false; // Set flag to false
        break; // Exit the loop if stock is not available
    }

    // Store cart item for later processing
    $cart_items[] = $cart_item;
}

// If stock is available, proceed with order placement
if ($stock_available) {
    // Calculate total amount including discounts
    $total_amount = 0;

    foreach ($cart_items as $cart_item) {
        $quantity = $cart_item['quantity'];
        $price = $cart_item['price'];
        $discount = $cart_item['discount'] ?? 0; // Default to 0 if no discount

        $item_total = ($price * $quantity) - $discount;
        $total_amount += $item_total;
    }
    $total_amount-=$discountlalaal;

    // Insert order details into the orders table
    $insert_order_sql = "INSERT INTO orders (user_id, total_amount, shipping_address, billing_address, payment_method, tracking_number) 
                         VALUES ('$user_id', '$total_amount', '$address', '$address', '$payment_method', '$tracking_number')";
    $order_result = mysqli_query($conn, $insert_order_sql);
    $order_id = mysqli_insert_id($conn);  // Get the newly created order ID

    // Insert order items from the cart into order_items table and reduce stock
    foreach ($cart_items as $cart_item) {
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $price = $cart_item['price'];
        $totalprice = $price * $quantity;

        // Insert into order_items
        $insert_order_item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price, total_price) 
                                  VALUES ('$order_id', '$product_id', '$quantity', '$price', '$totalprice')";
        mysqli_query($conn, $insert_order_item_sql);

        // Reduce stock quantity
        $update_stock_sql = "UPDATE products SET stock_quantity = stock_quantity - $quantity WHERE product_id = '$product_id'";
        mysqli_query($conn, $update_stock_sql);
    }

    // Clear the cart and remove discount after placing the order
    $clear_cart_sql = "DELETE FROM cart_items WHERE cart_id = (SELECT cart_id FROM carts WHERE user_id = '$user_id')";
    mysqli_query($conn, $clear_cart_sql);

    $remove_discount_sql = "UPDATE carts SET discount = 0 WHERE user_id = '$user_id'";
    mysqli_query($conn, $remove_discount_sql);

    // Handle payment based on the payment method
    if ($payment_method === 'cod') {
        // For COD, insert payment details (if needed) or set a status
        $payment_status = 'pending'; // Example status for COD
        $_SESSION['orderId'] = $order_id;
        $_SESSION['emailO'] = $email;
        $_SESSION['tracking_number'] = $tracking_number;
        $_SESSION['paymentM'] = $payment_method;
        $_SESSION['disountAmount']= $discountlalaal;
    } else {
        // For Stripe, do everything except insert payment details
        // $_SESSION['payment_details'] = [
        //     'order_id' => $order_id,
        //     'amount' => $total_amount,
        //     'payment_method' => $payment_method,
        //     'payment_status' => 'pending', // Set to pending or whatever is appropriate
        //     'email' => $email,
        //     'tn' => $tracking_number
        // ];
        $_SESSION['orderId'] = $order_id;
        $_SESSION['amount']=$total_amount;
        $_SESSION['paymentM'] = $payment_method;
        $_SESSION['emailO'] = $email;
        $_SESSION['tracking_number'] = $tracking_number;
        $_SESSION['disountAmount']= $discountlalaal;
    }

    // Redirect based on payment method
    if ($payment_method === 'cod') {
        echo "cod";
    } else {
        echo "stripe";
    }
} else {
    // If stock is not available, you can handle it here
    // The message has already been echoed above
}

function generateTrackingNumber($length = 12)
{
    // Characters to use in the tracking number
    $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $trackingNumber = '';
    $charsetLength = strlen($charset);

    // Generate random characters
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charsetLength - 1);
        $trackingNumber .= $charset[$randomIndex];
    }

    return $trackingNumber;
}
