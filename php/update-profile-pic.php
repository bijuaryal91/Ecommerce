<?php
include_once('../includes/connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profilepic']['tmp_name'];
        $fileName = $_FILES['profilepic']['name'];
        $fileSize = $_FILES['profilepic']['size'];
        $fileType = $_FILES['profilepic']['type'];
        $uploadFileDir = '../users/';

        // Get the current timestamp
        $timestamp = time();

        // Get the file extension
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Create a new file name with the timestamp
        $newFileName = 'profile_' . $timestamp . '.' . $fileExtension;

        // Set the destination path with the new file name
        $dest_path = $uploadFileDir . $newFileName;

        // Move the file to the specified directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $userId = $_SESSION['user_id'];
            $query = "UPDATE users SET profile_pic = '$newFileName' WHERE user_id = $userId";
            if (mysqli_query($conn, $query)) {
                echo 'File is successfully uploaded.';
            } else {
                echo 'Error updating the database.';
            }
        } else {
            echo 'There was an error moving the uploaded file.';
        }
    } else {
        echo 'No file uploaded or there was an upload error.';
    }
} else {
    echo 'Invalid request method.';
}
