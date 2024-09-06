<?php
// Include the database connection
include_once("./includes/connect.php");

// Initialize message variables
$message = "";
$messageClass = "";
$containerClass = "";
$iconClass = "";
$borderClass = "";
$buttonClass = "";

// Define the message and class based on the result
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database
    $sql = "SELECT * FROM users WHERE verification_token = '$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $created_at = $user['created_at'];
        $current_time = date("Y-m-d H:i:s");

        // Calculate the difference in time between token creation and current time
        $diff = strtotime($current_time) - strtotime($created_at);

        // If the difference is less than 2 minutes (120 seconds), verify the user
        if ($diff < 300) {
            $update = "UPDATE users SET verification = 'verified', verification_token = NULL WHERE verification_token = '$token'";
            if (mysqli_query($conn, $update)) {
                $message = "Your email has been verified successfully!";
                $messageClass = "success";
                $containerClass = "success-bg";
                $iconClass = "fa-check-circle";
                $borderClass = "success-border";
                $buttonClass = "success-button";
            } else {
                $message = "Error: " . mysqli_error($conn);
                $messageClass = "error";
                $containerClass = "error-bg";
                $iconClass = "fa-exclamation-circle";
                $borderClass = "error-border";
                $buttonClass = "error-button";
            }
        } else {
            $message = "The verification link has expired. Please try to sign in to send another link.";
            $messageClass = "error";
            $containerClass = "error-bg";
            $iconClass = "fa-exclamation-circle";
            $borderClass = "error-border";
            $buttonClass = "error-button";
        }
    } else {
        $message = "Invalid verification link!";
        $messageClass = "error";
        $containerClass = "error-bg";
        $iconClass = "fa-exclamation-circle";
        $borderClass = "error-border";
        $buttonClass = "error-button";
    }
} else {
    $message = "No verification token provided!";
    $messageClass = "info";
    $containerClass = "info-bg";
    $iconClass = "fa-info-circle";
    $borderClass = "info-border";
    $buttonClass = "info-button";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification - RK Stores</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
            margin: 0;
        }

        .container {
            width: 500px;
            height: 500px;
            box-shadow: 5px 5px 10px 2px #888;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            border: 5px solid; /* Default border */
        }

        .top-bar {
            text-align: center;
            width: 100%;
            height: 60%;
        }

        .fa-check-circle,
        .fa-exclamation-circle,
        .fa-info-circle {
            margin-top: 5px;
            font-size: 18em;
        }

        .bottom-bar {
            text-align: center;
            background-color: white;
            color: black; /* Text color for .bottom-bar */
            padding: 20px;
            margin-top: 5px;
            width: 92%;
            height: 40%;
        }

        h1 {
            font-family: 'Oswald', sans-serif;
            font-weight: bold;
            margin-bottom: -10px;
        }

        p.success {
            color: #28a745; /* Green for success */
        }

        p.error {
            color: #dc3545; /* Red for error */
        }

        p.info {
            color: #17a2b8; /* Blue for info */
        }

        button {
            border-radius: 10px;
            padding: 10px 20px;
            outline: none;
            transition: all 0.3s ease-in;
            color: white; /* Text color for button */
            border: none; /* Remove default border */
        }

        button.success-button {
            background: #28a745; /* Green background for success */
        }

        button.error-button {
            background: #dc3545; /* Red background for error */
        }

        button.info-button {
            background: #17a2b8; /* Blue background for info */
        }

        button:hover {
            opacity: 0.8;
        }

        .success-bg {
            background-color: #28a745; /* Green background for success */
        }

        .error-bg {
            background-color: #dc3545; /* Red background for error */
        }

        .info-bg {
            background-color: #17a2b8; /* Blue background for information */
        }

        .success-border {
            border-color: #28a745; /* Green border for success */
        }

        .error-border {
            border-color: #dc3545; /* Red border for error */
        }

        .info-border {
            border-color: #17a2b8; /* Blue border for info */
        }
    </style>
</head>

<body>
    <div class="container <?php echo $containerClass . ' ' . $borderClass; ?>">
        <div class="top-bar">
            <i class="fa <?php echo $iconClass; ?>" aria-hidden="true"></i>
        </div>
        <div class="bottom-bar">
            <h1>Verification Status</h1>
            <p class="<?php echo $messageClass; ?>"><?php echo $message; ?></p>
            <button class="<?php echo $buttonClass; ?>" onclick="window.location.href='./login.php'">Dismiss</button>
        </div>
    </div>
</body>

</html>
