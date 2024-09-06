<?php
    include("./connection.php");
    $id = $_GET['deleteId'];
    $sql = "DELETE FROM categories WHERE category_id = ".$id;
    if(mysqli_query($conn,$sql))
    {
        header("location:../category.php");
    }
?>