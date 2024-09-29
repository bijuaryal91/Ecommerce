<?php
include_once("../connection.php");


// Get current year
$currentYear = date('Y');

// Prepare SQL query to count orders per month
$sql = "SELECT MONTH(created_at) AS month, COUNT(*) AS order_count 
        FROM orders 
        WHERE YEAR(created_at) = $currentYear 
        GROUP BY MONTH(created_at) 
        ORDER BY MONTH(created_at)";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold user counts
$orderCounts = array_fill(0, 12, 0); // Default to zero for each month

if ($result->num_rows > 0) {
    // Fetch the data
    while ($row = $result->fetch_assoc()) {
        $orderCounts[$row['month'] - 1] = (int)$row['order_count']; // Store count at the respective month index
    }
}

// Close the database connection
$conn->close();

// Return JSON data
header('Content-Type: application/json');
echo json_encode($orderCounts);
?>
