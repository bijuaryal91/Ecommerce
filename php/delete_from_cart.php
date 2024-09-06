<?php
include_once('../includes/connect.php');
session_start();

if (!isset($_SESSION['user_status'])) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Get the user's cart
    $cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_sql);

    if (mysqli_num_rows($cart_result) > 0) {
        $cart = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart['cart_id'];

        // Remove the product from the cart
        $delete_sql = "DELETE FROM cart_items WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
        if(mysqli_query($conn, $delete_sql)){
            header("location: ../cart.php");
        }
        else
        {
            echo "Wrong";
        }

        
    } else {
        echo "Cart not found!";
    }
} else {
    echo "No product selected!";
}

mysqli_close($conn);
?>
