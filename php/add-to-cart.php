<?php
include_once('../includes/connect.php');
session_start();

if (!isset($_SESSION['user_status'])) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Assuming user is logged in

if (isset($_GET['productId']) && isset($_GET['quantity'])) {
    $product_id = $_GET['productId'];
    $quantity = intval($_GET['quantity']); // Ensure quantity is an integer

    // Retrieve product price
    $price_sql = "SELECT price FROM products WHERE product_id = '$product_id'";
    $price_result = mysqli_query($conn, $price_sql);

    if (mysqli_num_rows($price_result) == 0) {
        echo "Product not found!";
        exit();
    }

    $product = mysqli_fetch_assoc($price_result);
    $price = $product['price'];
    $total_price = $price * $quantity; // Calculate total price

    // Check if the cart already exists for the user
    $cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_sql);

    if (mysqli_num_rows($cart_result) == 0) {
        // Create a new cart for the user if it doesn't exist
        $create_cart_sql = "INSERT INTO carts (user_id) VALUES ('$user_id')";
        mysqli_query($conn, $create_cart_sql);
        $cart_id = mysqli_insert_id($conn);
    } else {
        $cart = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart['cart_id'];
    }

    // Check if the product is already in the cart
    $check_sql = "SELECT * FROM cart_items WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Update quantity and total price if product already in cart
        $update_sql = "UPDATE cart_items SET quantity = quantity + '$quantity', total_price = total_price + '$total_price' WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
        mysqli_query($conn, $update_sql);
    } else {
        // Insert the product into the cart
        $insert_sql = "INSERT INTO cart_items (cart_id, product_id, quantity, price, total_price) VALUES ('$cart_id', '$product_id', '$quantity', '$price', '$total_price')";
        mysqli_query($conn, $insert_sql);
    }

    // Remove the product from the wishlist after adding it to the cart
    $delete_wishlist_sql = "DELETE FROM wishlist_items WHERE product_id = '$product_id' AND wishlist_id IN (SELECT wishlist_id FROM wishlists WHERE user_id = '$user_id')";
    mysqli_query($conn, $delete_wishlist_sql);

    header("location: ../cart.php");
} elseif (isset($_GET['productId'])) {
    $product_id = $_GET['productId'];

    // Retrieve product price
    $price_sql = "SELECT price FROM products WHERE product_id = '$product_id'";
    $price_result = mysqli_query($conn, $price_sql);

    if (mysqli_num_rows($price_result) == 0) {
        echo "Product not found!";
        exit();
    }

    $product = mysqli_fetch_assoc($price_result);
    $price = $product['price'];
    $total_price = $price; // For single item, total price is price

    // Check if the cart already exists for the user
    $cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
    $cart_result = mysqli_query($conn, $cart_sql);

    if (mysqli_num_rows($cart_result) == 0) {
        // Create a new cart for the user if it doesn't exist
        $create_cart_sql = "INSERT INTO carts (user_id) VALUES ('$user_id')";
        mysqli_query($conn, $create_cart_sql);
        $cart_id = mysqli_insert_id($conn);
    } else {
        $cart = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart['cart_id'];
    }

    // Check if the product is already in the cart
    $check_sql = "SELECT * FROM cart_items WHERE cart_id = '$cart_id' AND product_id = '$product_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Alert if product is already in cart
        echo "<script>alert('Product is already in your cart!'); window.location.href = '../cart.php';</script>";
    } else {
        // Insert the product into the cart
        $insert_sql = "INSERT INTO cart_items (cart_id, product_id, quantity, price, total_price) VALUES ('$cart_id', '$product_id', '1', '$price', '$total_price')";
        mysqli_query($conn, $insert_sql);

        // Remove the product from the wishlist after adding it to the cart
        $delete_wishlist_sql = "DELETE FROM wishlist_items WHERE product_id = '$product_id' AND wishlist_id IN (SELECT wishlist_id FROM wishlists WHERE user_id = '$user_id')";
        mysqli_query($conn, $delete_wishlist_sql);
    }

    header("location: ../cart.php");
} else {
    echo "No product selected!";
}

mysqli_close($conn);
?>
