<?php
include_once("../includes/connect.php");
session_start();
$address = $_POST['address'];
$street = $_POST['street'];
$apart = $_POST['apart'];
$city = $_POST['city'];
$user_id = $_SESSION['user_id'];


if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE user_id='$user_id'"))>0)
{
    if(empty($address) || empty($street) || empty($city))
    {
        echo "All * fields are required!";
    }
    else
    {
        if(strlen($address)<3)
        {
            echo "Address is too short!";
        }
        else
        {
            if(strlen($street)<3)
            {
                echo "Street name is too short!";
            }
            else
            {
                if(strlen($city)<3)
                {
                    echo "City name is too short!";
                }
                else
                {
                    if(mysqli_query($conn,"UPDATE users SET address='$address',street='$street',apartment='$apart',city='$city' WHERE user_id='$user_id'"))
                    {
                        echo "success";
                    }
                    else{
                        echo "Something went wrong";
                    }
                }
            }
        }
    }
}
else
{
    echo "No Users Found";
}

?>