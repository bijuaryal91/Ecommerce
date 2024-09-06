<?php
include_once("../includes/connect.php");

$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);
$password = md5($pass); // Encrypt the password
session_start();

// Check if the user with the provided email exists
$sql_check_user = "SELECT * FROM users WHERE email='$email'";
$result_check_user = mysqli_query($conn, $sql_check_user);

if (mysqli_num_rows($result_check_user) > 0) {
    // User exists, proceed to check password and other conditions
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if the account is active and verified
        if ($row['status'] === 'active') {
            if ($row['verification'] === 'verified') {
                // Set session variables
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user_status'] = "loggedin";
                $_SESSION['name'] = $row['first_name'];
                echo "success";
            } else {
                echo "Account is not verified! Please check your email for verification.";
            }
        } else {
            echo "Account is disabled! You can't log in.";
        }
    } else {
        echo "Incorrect password!";
    }
} else {
    echo "User does not exist. Please sign up!";
}

// Close the database connection
mysqli_close($conn);
?>
