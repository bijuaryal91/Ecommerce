<?php
include_once("./connection.php");


$name = mysqli_real_escape_string($conn, $_POST['cname']);
$name_parts = explode(' ', $name);

$fname = isset($name_parts[0]) ? $name_parts[0] : '';
$lname = isset($name_parts[count($name_parts) - 1]) ? $name_parts[count($name_parts) - 1] : '';
if (count($name_parts) > 2) {
    $lname = implode(' ', array_slice($name_parts, 1));
}
$email = mysqli_real_escape_string($conn, $_POST['cd']);
$password = mysqli_real_escape_string($conn, $_POST['pass']);
$pass = md5($password);

if (!empty($name) && !empty($email) && !empty($password)) {
    if (strlen($password < 8)) {
        echo "Password must be 8 character";
    } else {
        $sql = "INSERT INTO admin(fname,lname,email,password) VALUES('$fname','$lname','$email','$pass')";

        if (mysqli_query($conn, $sql)) {
            echo "success";
        }
    }
} else {
    echo "All fields required!";
}
