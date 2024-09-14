<?php
include_once("../includes/connect.php");
if(!isset($_GET['email']))
{
    header("location:../forgot-password.php");
    exit();
}
function generateOTP($length = 6)
{
    $otp = '';
    $characters = '0123456789';
    $max = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[random_int(0, $max)];
    }

    return $otp;
}
$email = $_GET['email'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $otp = generateOTP();
    $subject = "Your OTP Code";
    $message = "Your OTP code is: $otp";
    $headers = "From: contact@rkjewellers.com";

    if (mail($email, $subject, $message, $headers)) {
        $sql = "UPDATE users SET otp='$otp' WHERE email='$email'";
        if (mysqli_query($conn, $sql)) {
            setcookie("email", $email, time() + 3600, "/");
            header("location:../verify-otp.php");
        }
    } else {
        echo "Failed to send OTP.";
    }
} else {
    echo "No user found with this email. Please signup";
}
