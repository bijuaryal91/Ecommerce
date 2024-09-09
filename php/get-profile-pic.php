<?php
include_once("../includes/connect.php");
header('Content-Type: application/json');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows < 1) {
    echo json_encode(['success' => false, 'message' => 'Something Wrong']);
} else {
    $row = $result->fetch_assoc();
    $json_response = json_encode(['success' => true, 'profile_pic' => $row['profile_pic']]);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['success' => false, 'message' => 'JSON encoding error: ' . json_last_error_msg()]);
    } else {
        echo $json_response;
    }
}
