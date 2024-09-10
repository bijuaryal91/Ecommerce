<?php
include_once("./connection.php");

$id = mysqli_real_escape_string($conn, $_POST['id']);
$c = mysqli_real_escape_string($conn, $_POST['cname']);
$code_name =strtoupper($c);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$dates = mysqli_real_escape_string($conn, $_POST['date']);
$remaining = mysqli_real_escape_string($conn, $_POST['ru']);
$visibility = mysqli_real_escape_string($conn, $_POST['visibility']);

$currentTime = date("H:i:s");

$formattedDateTime = $dates . ' ' . $currentTime;


if (!empty($code_name) && !empty($dates) && !empty($remaining) && !empty($visibility)) {
    if (is_numeric($remaining) && $remaining >= 0) {
        if (is_numeric($price) && $price >= 0) {
            $sql = "UPDATE redeemcode set code='$code_name',price='$price',expires_at='$formattedDateTime',remaining_Usage='$remaining', visibility='$visibility' WHERE code_Id='$id'";
    
            if (mysqli_query($conn, $sql)) {
                echo "success";
            }
        } else {
            echo "Only Positive Number Allowed in price";
        }
    } else {
        echo "Only Positive Number Allowed in Usage";
    }
} else {
    echo "All fields required!";
}
