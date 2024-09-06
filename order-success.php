<?php
ob_start();
session_start();
include_once("./includes/connect.php");

if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
    exit();
}
if (!isset($_SESSION['orderId'])) {
    header("location:index.php");
    exit();
}

if (!isset($_COOKIE['isCameFromCart']) || $_COOKIE['isCameFromCart'] != "true") {
    header("location:cart.php");
    exit();
}

// Clear the cookie
$cookie_name = "isCameFromCart";

// Check if the cookie exists
if (isset($_COOKIE[$cookie_name])) {
    // Delete the cookie by setting its expiration date to a past time
    setcookie($cookie_name, "", [
        'expires' => time() - 3600,  // Set expiration date in the past
        'path' => '/reeyaEcommerce',               // Ensure path matches
        'domain' => 'localhost',              // Ensure domain matches if used
        'secure' => true,           // Same Secure flag as used when setting the cookie
        'httponly' => false,        // Same HttpOnly flag as used when setting the cookie
        'samesite' => 'None'        // Same SameSite attribute as used when setting the cookie
    ]);
}

// Fetch order details from the database
$user_id = $_SESSION['user_id'];
$order_id = $_SESSION['orderId']; // Assuming you stored the order ID in the session after placing the order

// Fetch client information
$user_sql = "SELECT first_name, last_name, address, phone_number FROM users WHERE user_id = '$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user_info = mysqli_fetch_assoc($user_result);

// Fetch order details
$order_sql = "SELECT total_amount, payment_method, payment_status, created_at FROM orders WHERE order_id = '$order_id'";
$order_result = mysqli_query($conn, $order_sql);
$order_info = mysqli_fetch_assoc($order_result);

// Fetch order items with material and weight
$order_items_sql = "SELECT oi.product_id, oi.quantity, p.price, p.name, p.material, p.weight 
                    FROM order_items oi 
                    JOIN products p ON oi.product_id = p.product_id 
                    WHERE oi.order_id = '$order_id'";
$order_items_result = mysqli_query($conn, $order_items_sql);

// Calculate total amount
$total_amount = 0;
$order_items = [];
while ($item = mysqli_fetch_assoc($order_items_result)) {
    $item['sub_total'] = $item['quantity'] * $item['price'];
    $total_amount += $item['sub_total'];
    $order_items[] = $item;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Rk Stores</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            font-size: 16px;
            line-height: 30px;
        }

        .pad-top-botm {
            padding-bottom: 40px;
            padding-top: 40px;
        }

        h4 {
            text-transform: uppercase;
        }

        .contact-info span {
            font-size: 14px;
            padding: 0px 50px 0px 50px;
        }

        .contact-info hr {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .client-info {
            font-size: 15px;
        }

        .ttl-amts {
            text-align: right;
            padding-right: 50px;
        }

        .logo {
            width: 100px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row pad-top-botm ">
            <div class="col-lg-6 col-md-6 col-sm-6 ">
                <img class="logo " src="./logo.png" style="padding-bottom:20px;">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <strong>New RK Stores</strong>
                <br>
                <i>Address :</i> Hetauda - 10 , Makwanpur
                <br>
                Buskpark Road
                <br>
                Nepal
            </div>
        </div>
        <div class="row text-center contact-info">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <hr>
                <span>
                    <strong>Email : </strong> contact@rkstores.com
                </span>
                <span>
                    <strong>Call : </strong> +977 9811111112
                </span>
                <span>
                    <strong>Fax : </strong> 012340-908- 890
                </span>
                <hr>
            </div>
        </div>
        <div class="row pad-top-botm client-info">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h4> <strong>Client Information</strong></h4>
                <strong> <?php echo $user_info['first_name'] . ' ' . $user_info['last_name']; ?></strong>
                <br>
                <b>Address :</b> <?php echo $user_info['address']; ?>
                <br>
                <b>Call :</b> <?php echo $user_info['phone_number']; ?>
                <br>
                <b>E-mail :</b> <?php echo $_SESSION['emailO']; // Assuming you have stored user email in session 
                                ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <h4> <strong>Payment Details </strong></h4>
                <b>Bill Amount : Rs. <?php echo $order_info['total_amount']; ?></b>
                <br>
                Bill Date : <?php echo date('d F Y', strtotime($order_info['created_at'])); ?>
                <br>
                <b>Payment Status : <?php echo $order_info['payment_status']; ?> </b>
                <br>
                Delivery Date : <?php echo date('d F Y', strtotime($order_info['created_at'] . ' + 3 days')); // Assuming delivery is 7 days after order date 
                                ?>
                <br>
                Payment Method : <?php echo $_SESSION['paymentM'] // Assuming delivery is 7 days after order date 
                                    ?><br>
                Tracking No : <?php echo $_SESSION['tracking_number']; ?>
                <br>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Material</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order_items as $item): ?>
                                <tr>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['material']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>Rs. <?php echo $item['price']; ?></td>
                                    <td>Rs. <?php echo $item['sub_total']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="ttl-amts">
                    <h5> Total Amount : Rs. <?php echo $total_amount; ?> </h5>
                    <h5> Discounted Amount : Rs. <?php echo $_SESSION['disountAmount']; ?> </h5>
                </div>
                <hr>
                <hr>
                <div class="ttl-amts">
                    <h4> <strong>Bill Amount : Rs. <?php echo $order_info['total_amount']; ?></strong> </h4>
                </div>
            </div>
        </div>
        <div class="row pad-top-botm no-print">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <hr>
                <a href="#" onclick="window.print(); return false;" class="btn btn-primary btn-lg">Print Invoice</a>
                &nbsp;&nbsp;&nbsp;
                <a href="#" onclick="downloadPDF(); return false;" class="btn btn-success btn-lg">Download In Pdf</a>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function downloadPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Temporarily hide the buttons
            const buttons = document.querySelector('.no-print');
            buttons.style.display = 'none';

            // Select the correct element
            const element = document.querySelector('body');

            if (element) {
                html2canvas(element).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = 210; // Width of the PDF (A4 size)
                    const imgHeight = canvas.height * imgWidth / canvas.width;
                    doc.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);
                    doc.save('invoice.pdf');

                    // Show the buttons again after PDF is generated
                    buttons.style.display = 'block';
                }).catch(function(error) {
                    console.error('Error generating PDF:', error);
                    // Show the buttons again if there was an error
                    buttons.style.display = 'block';
                });
            } else {
                console.error('Error: Unable to find the container element.');
            }
        }

        window.downloadPDF = downloadPDF;
    });
</script>

</html>




<?php
// Store the required session values temporarily
$temp_user_id = $_SESSION['user_id'];
$temp_user_status = $_SESSION['user_status'];
$temp_name = $_SESSION['name'];

// Destroy all session variables
session_unset();

// Restore the required session values
$_SESSION['user_id'] = $temp_user_id;
$_SESSION['user_status'] = $temp_user_status;
$_SESSION['name'] = $temp_name;
?>