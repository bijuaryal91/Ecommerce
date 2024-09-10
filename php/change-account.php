<?php

include_once("../includes/connect.php");

session_start();
$userId = $_SESSION['user_id'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = "";
$phone = $_POST['phone'];

if (isset($_POST['email']) || $email !== "") {
    echo "You can not change your email";
    exit();
}

$sql = "SELECT * FROM users WHERE user_id='$userId'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if (empty($fname) || empty($fname) || empty($phone)) {
        echo "All fields are required";
    } else {
        if (strlen($fname) < 3) {
            echo "Fname should be 3 character long!";
        } else {
            if (strlen($lname) < 3) {
                echo "Lname should be 3 character long!";
            } else {
                if (preg_match('/^[0-9]{10}+$/', $phone)) {
                    if(mysqli_query($conn,"UPDATE users SET first_name='$fname',last_name='$lname',phone_number='$phone' WHERE user_id='$userId'"))
                    {
                        echo "success";
                    }
                    else
                    {
                        echo "Something went wrong";
                    }
                } else {
                    echo "Invalid Phone Number";
                }
            }
        }
    }
} else {
    echo "Something went wrong!";
}
