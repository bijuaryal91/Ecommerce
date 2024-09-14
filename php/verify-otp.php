<?php
include_once("../includes/connect.php");
$email = $_COOKIE['email'];
$otp = $_POST['otp'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
if($row['otp']===$otp)
{
    setcookie("isMatched", "true", time() + 3600, "/");
    echo "success";
}
else
{
    echo "OTP did not matched";
}
