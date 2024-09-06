<?php
session_start();
include_once("../includes/connect.php");

if (!isset($_SESSION['user_status'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $wishlist_id = $_POST['wishlist_id'];
    $user_id = $_SESSION['user_id'];

    // Get all items from the wishlist
    $sql = "SELECT product_id FROM wishlist_items WHERE wishlist_id = $wishlist_id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product_id = $row['product_id'];

            // Check if the item is already in the cart
            $cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
            $cart_result = mysqli_query($conn, $cart_sql);
            $cart = mysqli_fetch_assoc($cart_result);
            $cart_id = $cart['cart_id'];

            // If the cart does not exist, create a new cart
            if (!$cart_id) {
                $insert_cart_sql = "INSERT INTO carts (user_id) VALUES ('$user_id')";
                mysqli_query($conn, $insert_cart_sql);
                $cart_id = mysqli_insert_id($conn);
            }

            // Check if the product is already in the cart
            $check_cart_sql = "SELECT * FROM cart_items WHERE cart_id = $cart_id AND product_id = $product_id";
            $check_cart_result = mysqli_query($conn, $check_cart_sql);

            if (mysqli_num_rows($check_cart_result) > 0) {
                // If the product is already in the cart, update the quantity
                $update_quantity_sql = "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = $cart_id AND product_id = $product_id";
                mysqli_query($conn, $update_quantity_sql);
            } else {
                // Otherwise, add the product to the cart
                $insert_cart_item_sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES ($cart_id, $product_id, 1)";
                mysqli_query($conn, $insert_cart_item_sql);
            }
        }

        // Remove items from wishlist after adding to cart
        $delete_wishlist_items_sql = "DELETE FROM wishlist_items WHERE wishlist_id = $wishlist_id";
        mysqli_query($conn, $delete_wishlist_items_sql);

        header("Location: ../wishlist.php");
        exit();
    } else {
        header("Location: ../wishlist.php");
        exit();
    }
} else {
    header("Location: ../wishlist.php");
    exit();
}
