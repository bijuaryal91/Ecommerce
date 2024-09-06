<?php
include_once("./connection.php");

$email = mysqli_real_escape_string($conn, $_POST['email']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);
$password = md5($pass);
session_start();

if (!empty($email) && !empty($pass)) {

    $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Check if status is 'active'
        if ($row['status'] === 'active') {
            $_SESSION['admin_username'] = $email;
            $_SESSION['admin_user_id'] = $row['id'];
            $_SESSION['name'] = $row['fname'];
            echo "success";
        } else {
            echo "Account is disabled! You can't log in";
        }
    } else {
        echo "Username or Password is Incorrect";
    }
} else {
    echo "All Fields Are Required!";
}
?>
