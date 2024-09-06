<?php
include_once("./connection.php");

$id = mysqli_real_escape_string($conn, $_POST['hp']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);


if (!empty($password) && !empty($cpassword)) {
    if (strlen($password) < 8) {
        echo "Password must be 8 character long";
    } else {
        if ($password == $cpassword) {
            $npassword = md5($password);
            $sql = "UPDATE admin set password='$npassword' WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                echo "success";
            }
        } else {
            echo "Password doesnt match";
        }
    }
} else {
    echo "All fields required!";
}
