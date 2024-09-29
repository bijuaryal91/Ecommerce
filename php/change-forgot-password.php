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

$secretKey = "ai3wswUUG0ISDplpmmCTs/lKIqfl8kt3WrUikaTEx2A=";

function encryptPassword($data, $secretKey)
{
    // Initialization vector (IV) used for encryption (Base64 encoded)
    $ivBase64 = "TD3X/3oGsbZRDL7Rop8Vbg==";

    // Decode the Base64 encoded secret key and IV
    $encryptionKey = base64_decode($secretKey);
    $iv = base64_decode($ivBase64);

    // Specify the encryption algorithm to be used
    $encryptionAlgorithm = "AES-256-CBC";

    // Encrypt the data using the specified algorithm, key, and IV
    $encryptedText = openssl_encrypt($data, $encryptionAlgorithm, $encryptionKey, OPENSSL_RAW_DATA, $iv);

    // Encode the encrypted data to Base64 format for safe storage or transmission
    $encryptedTextBase64 = base64_encode($encryptedText);

    // Return the encrypted password in Base64 format
    return $encryptedTextBase64;
}

$pass = $_POST['password'];
$password = encryptPassword($pass,$secretKey);
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
