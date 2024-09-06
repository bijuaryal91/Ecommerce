<?php
include_once("./connection.php");


$c = mysqli_real_escape_string($conn, $_POST['cname']);
$price = mysqli_real_escape_string($conn, $_POST['price']);
$code = strtoupper($c);
$date = mysqli_real_escape_string($conn, $_POST['ed']);
$remaining = mysqli_real_escape_string($conn, $_POST['remaining']);
$currentTime = date("H:i:s");

$expiry_date = $date . ' ' . $currentTime;


if (!empty($code) && !empty($date) && !empty($remaining)) {
    if (is_numeric($remaining) && $remaining >= 0) {
        if (is_numeric($price) && $price >= 0) {
            $sql = "INSERT INTO redeemcode(code,price,expires_at,remaining_Usage) VALUES('$code','$price','$expiry_date','$remaining')";
    
            if (mysqli_query($conn, $sql)) {
                echo "success";
            }
        } else {
            echo "Only positive number allowed in price";
        }
    } else {
        echo "Only positive number allowed in remaining field";
    }
} else {
    echo "All fields required!";
}
