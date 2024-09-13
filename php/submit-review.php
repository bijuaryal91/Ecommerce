<?php
include_once("../includes/connect.php");
session_start();
if(!isset($_SESSION['user_status']))
{
    header("location:../login.php");
}
if(isset($_POST['submit']))
{
    $userid = $_POST['uid'];
    $rating = $_POST['rating'];
    $comment = $_POST['opinion'];
    $productId = $_POST['pid'];

    $sql = "INSERT INTO reviews(product_id,user_id,rating,comment) VALUES ('$productId','$userid','$rating','$comment')";
    if(mysqli_query($conn,$sql))
    {
        header("location:../product-details.php?productId=$productId");
    }
}


?>