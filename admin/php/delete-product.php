<?php
    include("./connection.php");
    $id = $_GET['deleteId'];
    $sql = "DELETE FROM products WHERE product_id = ".$id;
    if(mysqli_query($conn,$sql))
    {
        header("location:../products.php");
    }
?>