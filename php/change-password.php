<?php
include_once("../includes/connect.php");
session_start();

$oldPassword = $_POST['opassword'];
$newPassword = $_POST['password'];
$cNewPassword = $_POST['cpassword'];

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if ($row['password'] === md5($oldPassword)) {
    if (strlen($newPassword) < 8) {
        echo "Password must be 8 character!";
    } else {
        if ($newPassword === $cNewPassword) {
            if ($newPassword === $oldPassword) {
                echo "You can not change your password same as old!";
            } else {
                $password = md5($newPassword);

                if (mysqli_query($conn, "UPDATE users SET password='$password' WHERE user_id='$user_id'")) {
                    echo "success";
                } else {
                    echo "Something Went Wrong";
                }
            }
        } else {
            echo "Confirm Password Must Match Password!";
        }
    }
} else {
    echo "Old Password is Incorrect!";
}
