<?php
include_once('../connection.php');

// Initialize an array to hold the monthly sales data
$salesData = array_fill(0, 12, 0); // Create an array with 12 elements initialized to 0

// SQL query to select monthly sales
$query = "
    SELECT MONTH(order_date) AS month, SUM(total_amount) AS total_sales
    FROM orders
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
";

$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch results and populate the salesData array
    while ($row = mysqli_fetch_assoc($result)) {
        $month = (int)$row['month']; // Get the month number (1-12)
        $salesData[$month - 1] = (float)$row['total_sales']; // Store total sales in the correct month index
    }
}

// Close the database connection
mysqli_close($conn);

// Return the sales data as a JSON array
echo json_encode($salesData);
?>
