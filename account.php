<?php
session_start();
if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
    exit();
}
?>