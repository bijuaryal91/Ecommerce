<?php
include_once("../includes/connect.php");

header('Content-Type: application/json');

if (isset($_POST['coupon_code'])) {
    $coupon_code = $_POST['coupon_code'];
    $coupon_code = strtoupper($coupon_code);

    // Prepare and execute the statement to fetch coupon details
    $stmt = $conn->prepare("SELECT price, remaining_usage, expires_at FROM redeemcode WHERE code = ?");
    $stmt->bind_param("s", $coupon_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $currentDate = new DateTime(); // Current date and time
        $expiryDate = new DateTime($row['expires_at']); // Expiration date from database

        // Check remaining usage
        if ($row['remaining_usage'] <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Coupon code has no remaining usage']);
        }
        // Check expiration date
        elseif ($currentDate > $expiryDate) {
            echo json_encode(['status' => 'error', 'message' => 'Coupon code has expired']);
        } else {
            // Both checks passed
            $discountAmount = $row['price'];

            // Update remaining usage in the database
            $updateStmt = $conn->prepare("UPDATE redeemcode SET remaining_usage = remaining_usage - 1 WHERE code = ?");
            $updateStmt->bind_param("s", $coupon_code);
            $updateStmt->execute();
            $updateStmt->close();

            // Assuming user_id is stored in the session
            session_start();
            $user_id = $_SESSION['user_id'];

            // Update the discount column in the carts table for the user
            $cartUpdateStmt = $conn->prepare("UPDATE carts SET discount = ? WHERE user_id = ?");
            $cartUpdateStmt->bind_param("di", $discountAmount, $user_id); // "d" for double (price), "i" for integer (user_id)
            $cartUpdateStmt->execute();
            $cartUpdateStmt->close();

            echo json_encode(['status' => 'success', 'discount' => $discountAmount]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid coupon code']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No coupon code provided']);
}
