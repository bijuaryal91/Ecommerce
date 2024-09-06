<?php
    include("./connection.php");
    $id = $_GET['deleteId'];
    $sql = "DELETE FROM redeemcode WHERE code_Id = ".$id;
    if(mysqli_query($conn,$sql))
    {
        header("location:../redeem-code.php");
    }
?>