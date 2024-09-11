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

        // HTML email content
        $message = "
        <html>
        <head>
            <title>Verify Your Email Address</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: auto;
                    background: #ffffff;
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
              
                
                h2 {
                    color: #333;
                }
                p {
                    color: #555;
                    line-height: 1.5;
                }
                .button {
                    display: inline-block;
                    padding: 15px 25px;
                    font-size: 16px;
                    color: #ffffff;
                    background-color: #007BFF;
                    text-decoration: none;
                    border-radius: 5px;
                    transition: background-color 0.3s;
                }
                .button:hover {
                    background-color: #0056b3;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #777777;
                    text-align: center;
                }
                .ii a[href]
                {
                    color:#fff;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                
                <h2>Hello $fname,</h2>
                <p>Thank you for signing up! Please click the button below to verify your email address:</p>
                <a href='$verification_link' class='button'>Verify Email Address</a>
                <p class='footer'>If you did not create an account, no further action is required.</p>
            </div>
        </body>
        </html>
        ";

        // Set content-type header for sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: noreply@rkstores.com" . "\r\n";

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
