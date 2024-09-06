<?php
include_once("./connection.php");

$id = mysqli_real_escape_string($conn,$_POST['id']);
$category_name = mysqli_real_escape_string($conn, $_POST['cname']);
$category_d = mysqli_real_escape_string($conn, $_POST['cd']);


if (!empty($category_name) && !empty($category_d)) {
    $sql = "UPDATE categories set category_name='$category_name',description='$category_d' WHERE category_id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    }
}
else
{
    echo "All fields required!";
}
