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

    // Check if the user has a wishlist
    $sql = "SELECT wishlist_id FROM wishlists WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $wishlist = mysqli_fetch_assoc($result);
        $wishlist_id = $wishlist['wishlist_id'];

        // Delete the product from the wishlist
        $delete_sql = "DELETE FROM wishlist_items WHERE wishlist_id = '$wishlist_id' AND product_id = '$product_id'";
        if (mysqli_query($conn, $delete_sql)) {
            // Redirect back to the wishlist page after deletion
            header("location: ../wishlist.php");
        } else {
            echo "Error removing product from wishlist: " . mysqli_error($conn);
        }
    } else {
        echo "Wishlist not found!";
    }
} else {
    echo "No product selected!";
}

mysqli_close($conn);
