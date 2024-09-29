<?php
include_once('../connection.php');

// Fetch category data from the database
$query = "SELECT category_name, count FROM categories GROUP BY category_name";
$result = mysqli_query($conn, $query);

$categories = [];
$values = [];

if ($result) {
    // Calculate total count
    $totalCount = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category_name']; 
        $values[] = $row['count']; 
        $totalCount += $row['count']; // Accumulate total count
    }

    // Convert values to percentage
    $percentValues = [];
    if ($totalCount > 0) {
        foreach ($values as $value) {
            $percentValues[] = ($value / $totalCount) * 100; // Calculate percentage
        }
    } else {
        // If total count is zero, set all percentages to zero
        $percentValues = array_fill(0, count($values), 0);
    }
} else {
    // Handle error
    echo json_encode(['error' => 'Database query failed.']);
    exit;
}

$categoryData = [
    'labels' => $categories,
    'values' => $percentValues // Use percentage values
];

header('Content-Type: application/json'); // Set the correct content type
echo json_encode($categoryData);
