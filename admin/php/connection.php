<?php
// Database configuration
$host = 'localhost'; // or your database host
$username = 'root'; // your database username
$password = ''; // your database password
$database = 'rk_db'; // your database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Close connection
// $conn->close(); // Uncomment if you want to close the connection immediately
?>
