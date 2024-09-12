<?php
session_start();
if (!isset($_SESSION['admin_user_id'])) {
    header("location:./login.php");
}
$connection = mysqli_connect("localhost", "root", "", "rk_db");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">k -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <title>Dashboard - RK Stores</title>

</head>

<body>
    <div class="notification-wrapper">
        <div class="notification-toast">
            <div class="notification-content">
                <div class="notification-icon"><i class="uil uil-wifi"></i></div>
                <div class="notification-details">
                    <span>You're online now</span>
                    <p>Hurray! Internet is connected.</p>
                </div>
            </div>
            <div class="notification-close-icon"><i class="uil uil-times"></i></div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bx-code-alt' style="visibility: hidden;"></i>
            <div class="logo-name"><span>RK</span>Store</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="index.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="generate-report.php"><i class='bx bx-credit-card-front'></i>Generate Reports</a></li>
            <li><a href="products.php"><i class='bx bx-store-alt'></i>Products</a></li>
            <li><a href="add-product.php"><i class='bx bxl-product-hunt'></i>Add Products</a></li>
            <li><a href="category.php"><i class='bx bx-category'></i>Category</a></li>
            <li><a href="users.php"><i class='bx bx-group'></i>Customers</a></li>
            <li><a href="admin.php"><i class='bx bx-group'></i>Admins</a></li>
            <li><a href="orders.php"><i class='bx bx-store-alt'></i>Orders</a></li>
            <li><a href="payments.php"><i class='bx bxl-paypal'></i>Payments</a></li>
            <li><a href="redeem-code.php"><i class='bx bxs-coupon'></i>Redeem Code</a></li>
        </ul>
        <ul class="side-menu logout-menu">
            <li>
                <a href="./include/logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input" style="visibility: hidden;">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <?php
            // Query to get pending orders
            $sqli = "SELECT * FROM orders WHERE status='pending'";
            $resulti = mysqli_query($connection, $sqli);
            ?>
            <p>Welcome, <?php echo $_SESSION['name']; ?></p>

            <!-- Notification Icon with Dropdown -->
            <div class="notif">
                <a href="#">
                    <i class='bx bx-bell'></i>
                    <span class="count"><?php echo mysqli_num_rows($resulti); ?></span>
                </a>

                <!-- Dropdown Menu -->
                <div class="dropdown-content">
                    <ul>
                        <?php if (mysqli_num_rows($resulti) > 0) {
                            while ($order = mysqli_fetch_assoc($resulti)) { ?>
                                <li>
                                    <a href="view-orders.php?orderId=<?php echo $order['order_id']; ?>">
                                        New Order #<?php echo $order['order_id']; ?>
                                    </a>
                                </li>
                            <?php }
                        } else { ?>
                            <li>No pending orders</li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <a href="settings.php" class="profile">
                <img src="../logo.png">
            </a>
        </nav>

        <!-- End of Navbar -->
        <!-- <div class="notification">
            <ul>
                <?php
                // while ($rowi = mysqli_fetch_assoc($resulti)) {
                //     echo "<li><a href='view-order.php?orderid=" . $rowi['order_id'] . "'></a></li>";
                // }
                ?>
            </ul>
        </div> -->


        <script>
            // Selecting all required elements
            const notificationWrapper = document.querySelector(".notification-wrapper"),
                notificationToast = notificationWrapper.querySelector(".notification-toast"),
                notificationTitle = notificationToast.querySelector("span"),
                notificationSubTitle = notificationToast.querySelector("p"),
                notificationWifiIcon = notificationToast.querySelector(".notification-icon"),
                notificationCloseIcon = notificationToast.querySelector(".notification-close-icon");

            // Function to update the notification based on online/offline status
            function updateOnlineStatus() {
                if (navigator.onLine) {
                    notificationToast.classList.remove("offline");
                    notificationTitle.innerText = "You're online now";
                    notificationSubTitle.innerText = "Hurray! Internet is connected.";
                    notificationWifiIcon.innerHTML = '<i class="uil uil-wifi"></i>';
                    notificationWrapper.classList.remove("hide");

                    // Hide the toast notification automatically after 5 seconds
                    setTimeout(() => {
                        notificationWrapper.classList.add("hide");
                    }, 5000);
                } else {
                    offline();
                }
            }

            // Function for offline status
            function offline() {
                notificationWrapper.classList.remove("hide");
                notificationToast.classList.add("offline");
                notificationTitle.innerText = "You're offline now";
                notificationSubTitle.innerText = "Oops! Internet is disconnected.";
                notificationWifiIcon.innerHTML = '<i class="uil uil-wifi-slash"></i>';
            }

            // Event listeners for online and offline events
            window.addEventListener('online', updateOnlineStatus);
            window.addEventListener('offline', updateOnlineStatus);

            // Initially hide the notification wrapper
            notificationWrapper.classList.add("hide");

            // Close icon click event
            notificationCloseIcon.onclick = () => {
                notificationWrapper.classList.add("hide");
            };
        </script>