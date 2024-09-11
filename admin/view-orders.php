<?php
ob_start();
include_once("./include/sidebar.php");
include_once('./php/connection.php');

if (!isset($_SESSION['admin_user_id'])) {
    header("location:login.php");
    exit();
}
if (!isset($_GET['orderId'])) {
    header("location:orders.php");
    exit();
}

$orderId = $_GET['orderId'];
?>


<main>
    <div class="header">
        <div class="left">
            <h1>Process Orders</h1>
        </div>
        <a href="#" class="report" onclick="printOrders()">
            <i class='bx bx-printer'></i>
            <span>Print</span>
        </a>
    </div>
    <?php
    $sql = "SELECT * FROM orders WHERE order_id='$orderId'";
    $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $userid = $row['user_id'];

    $sqlItems = "SELECT * FROM order_items WHERE order_id='$orderId'";
    $resultItems = mysqli_query($conn, $sqlItems);
    $totalPriceItems = 0;
    while ($rowItems = mysqli_fetch_assoc($resultItems)) {
        $totalPriceItems += $rowItems['total_price'];
    }
    ?>
    <div class="container processContainer">
        <div class="order-processing-table processtable">
            <div class="heading">Order Processing</div>
            <table id="example" class="display responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>Order</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment Mode</th>
                        <th>Discounts</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $row['order_id'] ?></td>
                        <td><?php echo $row['order_date'] ?></td>
                        <td><?php echo $row['status'] ?></td>
                        <td><?php echo $row['payment_method'] ?></td>
                        <td><?php echo $totalPriceItems - $row['total_amount'] ?></td>
                        <td><?php echo $row['total_amount'] ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="order-productdetails-table processtable">
            <div class="heading">Product Details</div>
            <table id="example1" class="display responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>Product Id</th>
                        <th>Product</th>
                        <th>Quanity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sqlItems = "SELECT * FROM order_items WHERE order_id='$orderId'";
                    $resultItems = mysqli_query($conn, $sqlItems);

                    while ($rowItems = mysqli_fetch_assoc($resultItems)) {
                        $sqlProducts = "SELECT * FROM products WHERE product_id=" . $rowItems['product_id'];
                        $rowProducts = mysqli_fetch_assoc(mysqli_query($conn, $sqlProducts));
                    ?>
                        <tr>
                            <td><?php echo $rowItems['product_id'] ?></td>
                            <td><?php echo $rowProducts['name'] ?></td>
                            <td><?php echo $rowItems['quantity'] ?></td>
                            <td><?php echo $rowItems['price'] ?></td>
                            <td><?php echo $rowItems['total_price'] ?></td>


                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
        $sql = "SELECT * FROM users WHERE user_id='$userid'";
        $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        ?>
        <div class="order-address-table processtable">
            <div class="heading">Address Details</div>
            <table id="example2" class="display responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Street</th>
                        <th>Apartment</th>
                        <th>City</th>
                        <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $row['first_name'] . " " . $row['last_name'] ?></td>
                        <td><?php echo $row['address'] ?></td>
                        <td><?php echo $row['street'] ?></td>
                        <td><?php echo $row['apartment'] ?></td>
                        <td><?php echo $row['city'] ?></td>
                        <td><?php echo $row['phone_number'] ?></td>

                    </tr>
                </tbody>
            </table>
        </div>
        <div class="process-status">
            <?php
            // Fetch the current status of the order from the database
            $sql = "SELECT * FROM orders WHERE order_id='$orderId'";
            $row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
            $status = $row['status']; // The current order status from the database
            ?>
            <form method="post" action="./php/process-order.php">
                <?php
                if ($row['payment_method'] === "cod" && $row['payment_status'] === "pending") {
                ?>
                    <select name="paymentstatus" id="status">
                        <option value="pending">Payment Status - Pending</option>
                        <option value="paid">Payment Status - Paid</option>
                       </select>
                <?php
                }
                ?>
                <select name="status" id="status">
                    <option value="confirmed" <?php echo ($status == 'confirmed') ? 'selected' : ''; ?>>Order Status - Confirmed</option>
                    <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Order Status - Pending</option>
                    <option value="dispatched" <?php echo ($status == 'dispatched') ? 'selected' : ''; ?>>Order Status - Dispatched</option>
                    <option value="delivered" <?php echo ($status == 'delivered') ? 'selected' : ''; ?>>Order Status - Delivered</option>
                    <option value="cancelled" <?php echo ($status == 'cancelled') ? 'selected' : ''; ?>>Order Status - Cancelled</option>
                </select>
                <input type="hidden" name="orderId" value="<?php echo $orderId ?>">
                <input type="hidden" name="amount" value="<?php echo $row['total_amount'] ?>">
                <input type="hidden" name="paymentMethod" value="<?php echo $row['payment_method'] ?>">
                <button class="processBtn" name="submit">Update Order Status</button>
            </form>
        </div>

    </div>










</main>
<script>
    function printOrders() {
        var containerContent = document.querySelector('.container').outerHTML;
        var printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Print Container</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(containerContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
<script>
    // Get the current page's path
    const currentPath = window.location.pathname;

    // Select all the <li> elements
    const menuItems = document.querySelectorAll('li');

    // Loop through the <li> elements
    menuItems.forEach(item => {
        // Get the <a> tag and its href attribute
        const link = item.querySelector('a');
        const href = link.getAttribute('href');

        // Check if the currentPath matches the href
        if (currentPath.includes(href)) {
            // Add the 'active' class to the corresponding <li>
            item.classList.add('active');

            // Change the document title based on the active menu item's text
            document.title = link.textContent.trim() + " - RK Stores";
        } else {
            // Remove the 'active' class if it doesn't match
            item.classList.remove('active');
        }
    });
</script>

</div>

<script src="./js/index.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            lengthChange: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example1').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            lengthChange: true
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            responsive: true,
            paging: false,
            searching: false,
            ordering: false,
            info: false,
            lengthChange: true
        });
    });
</script>

</html>