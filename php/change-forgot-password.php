<?php

include("../includes/connect.php");
function sendPasswordChangedEmail($toEmail)
{
    // Email subject
    $subject = "Your Password Has Been Changed";

    // Email body/content
    $message = "
    <html>
    <head>
        <title>Password Changed Notification</title>
    </head>
    <body>
        <h1>Hello, Customer</h1>
        <p>We wanted to let you know that your account password has been successfully changed.</p>
        <p>If this change was not made by you, please contact us immediately.</p>
        <br>
        <p>Best regards,</p>
        <p>New Rk Jewellers</p>
    </body>
    </html>
    ";

    // Headers for email (HTML content, from address, etc.)
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@rkjewellers.com" . "\r\n";

    // Send email
    if (mail($toEmail, $subject, $message, $headers)) {
        return true;
    } else {
        return false;
    }
}


$pass = $_POST['password'];
$password = md5($pass);
$email = $_COOKIE['email'];
$sql = "UPDATE users SET password='$password' WHERE email='$email'";
if (mysqli_query($conn, $sql)) {
    if (sendPasswordChangedEmail($email)) {
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode('; ', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                // Unset each cookie by setting its expiration date in the past
                setcookie($name, '', time() - 3600, '/');
                // Remove from $_COOKIE array to avoid conflicts
                unset($_COOKIE[$name]);
            }
        }
        echo "success";
    } else {
        echo "Error";
    }
}
