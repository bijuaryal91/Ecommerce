<?php
include_once("../includes/connect.php");
session_start();


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
                $password = encryptPassword($newPassword,$secretKey);

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
