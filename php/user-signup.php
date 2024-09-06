<?php
// Include the database connection
include_once("../includes/connect.php");

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);
$cpass = mysqli_real_escape_string($conn, $_POST['cpassword']);
$password = md5($pass); // Encrypt the password
$verification_token = md5(rand()); // Generate a unique token
$created_at = date("Y-m-d H:i:s"); // Store the current timestamp

session_start();

// Check if the user already exists by email
$sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "User already exists with this email!";
} else {
    // Insert the new user into the database with default verification status as 'unverified'
    $insert = "INSERT INTO users (first_name, last_name, email, phone_number, password, verification_token, verification, created_at) 
               VALUES ('$fname', '$lname', '$email', '$phone', '$password', '$verification_token', 'unverified', '$created_at')";

    if (mysqli_query($conn, $insert)) {
        // Send verification email
        $to = $email;
        $subject = "Verify Your Email Address";
        $verification_link = "http://localhost/reeyaEcommerce/verify-user.php?token=" . $verification_token;
        $message = "Hello $fname,\n\nPlease click on the link below to verify your email address:\n$verification_link\n\nThank you!";
        $headers = "From: noreply@rkstores.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "success";
        } else {
            echo "Signup successful, but failed to send verification email.";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
