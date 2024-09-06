<?php
include_once('../includes/connect.php');
session_start();

if (!isset($_SESSION['user_status'])) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Assuming user is logged in and session holds user_id

if (isset($_GET['productId'])) {
    $product_id = $_GET['productId'];

    // Check if the user already has a wishlist
    $sql = "SELECT wishlist_id FROM wishlists WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        // Create a new wishlist for the user if not exists
        $sql = "INSERT INTO wishlists (user_id) VALUES ('$user_id')";
        mysqli_query($conn, $sql);
        $wishlist_id = mysqli_insert_id($conn);
    } else {
        $wishlist = mysqli_fetch_assoc($result);
        $wishlist_id = $wishlist['wishlist_id'];
    }

    // Check if the product is already in the wishlist
    $check_sql = "SELECT * FROM wishlist_items WHERE wishlist_id = '$wishlist_id' AND product_id = '$product_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // If product is already in wishlist, give an alert
        echo "<script>alert('Product is already in your wishlist!'); window.location.href = '../wishlist.php';</script>";
    } else {
        // Add the product to the wishlist
        $sql = "INSERT INTO wishlist_items (wishlist_id, product_id) VALUES ('$wishlist_id', '$product_id')";
        if (mysqli_query($conn, $sql)) {
            header("location: ../wishlist.php");
        } else {
            echo "Error adding product to wishlist: " . mysqli_error($conn);
        }
    }
} else {
    echo "No product selected!";
}

mysqli_close($conn);
