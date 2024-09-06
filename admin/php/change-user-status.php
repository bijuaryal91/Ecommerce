<?php
include("./connection.php");

$id = intval($_GET['id']); // Make sure to use intval to prevent SQL injection

// Fetch the current status
$sql = "SELECT status FROM users WHERE user_id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) < 1) {
    header("location:../users.php");
} else {

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Determine the new status
            $new_status = ($row['status'] === 'active') ? 'disabled' : 'active';

            // Update the status
            $update_sql = "UPDATE users SET status = '$new_status' WHERE user_id = $id";

            if (mysqli_query($conn, $update_sql)) {
                header("Location: ../users.php");
                exit(); // It's a good practice to call exit after redirecting
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            echo "No record found with ID $id";
        }
    } else {
        echo "Error fetching record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
