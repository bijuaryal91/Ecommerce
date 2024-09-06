<?php
include_once('../includes/connect.php');
session_start();

if (!isset($_SESSION['user_status'])) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Assuming user is logged in

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    $cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_sql);

    if (mysqli_num_rows($cart_result) > 0) {
        $cart = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart['cart_id'];

        foreach ($_POST['quantity'] as $product_id => $quantity) {
            $quantity = intval($quantity);

            // Retrieve the price for the current product
            $price_sql = "SELECT price FROM products WHERE product_id = '$product_id'";
            $price_result = mysqli_query($conn, $price_sql);

            if (mysqli_num_rows($price_result) > 0) {
                $product = mysqli_fetch_assoc($price_result);
                $price = $product['price'];
                $total_price = $price * $quantity; // Calculate total price

                if ($quantity > 0) {
                    // Update the cart item quantity and total price
                    $update_sql = "UPDATE cart_items SET quantity = '$quantity', price = '$price', total_price = '$total_price' WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
                    mysqli_query($conn, $update_sql);
                } else {
                    // Remove the item if quantity is 0 or less
                    $delete_sql = "DELETE FROM cart_items WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
                    mysqli_query($conn, $delete_sql);
                }
            } else {
                // Handle case where the product is not found
                echo "Product with ID $product_id not found.";
            }
        }
    }

    mysqli_close($conn);
    header("location: ../cart.php");
} else {
    echo "Invalid request!";
}
?>
