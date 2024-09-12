<?php

include_once('./connection.php');

if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    // Sanitize inputs
    $startDate = mysqli_real_escape_string($conn, $startDate);
    $endDate = mysqli_real_escape_string($conn, $endDate);

    // Modify the query to include details from products and customers tables
    $query = "
    SELECT 
    (SELECT COUNT(DISTINCT o.order_id) 
     FROM orders o 
     WHERE DATE(o.order_date) BETWEEN '$startDate' AND '$endDate') AS totalOrders,
     
    (SELECT COUNT(DISTINCT u.user_id) 
     FROM users u 
     WHERE DATE(u.created_at) BETWEEN '$startDate' AND '$endDate') AS totalCustomers,
     
    (SELECT COUNT(DISTINCT p.product_id) 
     FROM products p 
     WHERE DATE(p.created_at) BETWEEN '$startDate' AND '$endDate') AS totalProducts,
     
    (SELECT SUM(o.total_amount) 
     FROM orders o 
     WHERE DATE(o.order_date) BETWEEN '$startDate' AND '$endDate') AS totalAmount;

";




    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "Error fetching data"]);
    }
} else {
    echo json_encode(["error" => "Invalid date range"]);
}
