<?php
include_once("./connection.php");


$category_name = mysqli_real_escape_string($conn, $_POST['cname']);
$category_d = mysqli_real_escape_string($conn, $_POST['cd']);


if (!empty($category_name) && !empty($category_d)) {
    $sql = "INSERT INTO categories(category_name,description) VALUES('$category_name','$category_d')";

    if (mysqli_query($conn, $sql)) {
        echo "success";
    }
}
else
{
    echo "All fields required!";
}
