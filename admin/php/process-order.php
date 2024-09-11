<?php
session_start();
include_once("./connection.php");

if (!isset($_SESSION['admin_user_id'])) {
    header("location:../login.php");
    exit();
}

if (!isset($_POST['orderId']) || empty($_POST['orderId'])) {
    header("location:../orders.php");
    exit();
}

$paymentStatus = isset($_POST['paymentstatus']) ? mysqli_real_escape_string($conn, $_POST['paymentstatus']) : "";

if (isset($_POST['submit'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $orderId = mysqli_real_escape_string($conn, $_POST['orderId']);
    $paymentMethod = mysqli_real_escape_string($conn, $_POST['paymentMethod']); // Assuming you get payment method from form
    $transactionId = uniqid('TXN-', true);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);  // Assuming you get amount from form

    // Check if the order exists
    $sql = "SELECT * FROM orders WHERE order_id='$orderId'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        if ($paymentStatus === "pending") {
            echo "<script>
                alert('Check Payment Status Before Processing');
                window.location.href = '../view-orders.php?orderId=$orderId';
            </script>";
            exit();
        } else {
            // Construct the SQL update query for the order
            $updateSql = "UPDATE orders SET status='$status'";
            if ($paymentStatus === "paid") {
                $updateSql .= ", payment_status='$paymentStatus'";
            }
            $updateSql .= " WHERE order_id='$orderId'";

            // Execute the query and check if successful
            if (mysqli_query($conn, $updateSql)) {
                // If the payment status is "paid", insert into payments table
                if ($paymentStatus === "paid") {
                    $paymentDate = date('Y-m-d H:i:s'); // Capture current date and time
                    $insertPaymentSql = "
                        INSERT INTO payments 
                        (order_id, payment_method, payment_status, transaction_id, amount, payment_date)
                        VALUES
                        ('$orderId', '$paymentMethod', '$paymentStatus', '$transactionId', '$amount', '$paymentDate')";

                    if (mysqli_query($conn, $insertPaymentSql)) {
                        // Successfully inserted into payments table
                        header("location:../view-orders.php?orderId=$orderId");
                        exit();
                    } else {
                        echo "<script>alert('Something went wrong while inserting payment details');</script>";
                    }
                } else {
                    header("location:../view-orders.php?orderId=$orderId");
                    exit();
                }
            } else {
                echo "<script>alert('Something went wrong while updating the order');</script>";
            }
        }
    } else {
        echo "<script>alert('Order not found');</script>";
    }
}
