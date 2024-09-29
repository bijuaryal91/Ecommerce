<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php");
?>


<main>
    <div class="header">
        <div class="left">
            <h1>Dashboard</h1>
        </div>
        <a href="#" class="report" onclick="printData()">
            <i class='bx bx-printer'></i>
            <span>Print Report</span>
        </a>
    </div>

    <!-- Insights -->
    <ul class="insights">
        <li>
            <?php
            $sql = "SELECT * FROM orders";
            $row = mysqli_num_rows(mysqli_query($conn, $sql));
            ?>
            <i class='bx bx-calendar-check'></i>
            <span class="info">
                <h3>
                    <?php echo $row ?>
                </h3>
                <p>Orders</p>
            </span>
        </li>
        <?php
        $sql = "SELECT * FROM users";
        $row = mysqli_num_rows(mysqli_query($conn, $sql));
        ?>
        <li><i class='bx bx-show-alt'></i>
            <span class="info">
                <h3>
                    <?php echo $row ?>
                </h3>
                <p>Customers</p>
            </span>

        </li>
        <?php
        $sql = "SELECT * FROM products";
        $row = mysqli_num_rows(mysqli_query($conn, $sql));
        ?>
        <li><i class='bx bx-line-chart'></i>
            <span class="info">
                <h3>
                    <?php echo $row ?>
                </h3>
                <p>Products</p>
            </span>
        </li>
        <?php

        $sql = "SELECT SUM(total_amount) AS total_sum FROM orders WHERE payment_status='paid'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $total_sum = $row['total_sum'];
        } else {
            $total_sum = 0; // Default value in case of error
        }
        ?>
        <li><i class='bx bx-dollar-circle'></i>
            <span class="info">
                <h3>
                    <?php echo number_format($total_sum); ?>
                </h3>
                <p>Total Sales</p>
            </span>
        </li>


    </ul>
    <!-- End of Insights -->
    <?php

    // Query to fetch data from the 'categories' table
    $sql = "SELECT * FROM orders WHERE status NOT IN ('delivered', 'cancelled', 'pending')";

    $result = mysqli_query($conn, $sql);
    ?>
    <div class="container">
        <div class="heading" style="font-size: 20px; font-weight:bold;margin:20px 20px 20px 0;">These orders require further processing</div>
        <table id="example" class="display responsive nowrap" style="width: 100%;">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any records in the result
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each row of data
                    while ($row = mysqli_fetch_assoc($result)) {

                        $userId = $row['user_id'];
                        $userSql = "SELECT * FROM users WHERE user_id='$userId'";
                        $rowUser = mysqli_fetch_assoc(mysqli_query($conn, $userSql));
                        echo "<tr data-id=" . $row['order_id'] . " class='clickable-row'>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $rowUser['first_name'] . " " . $rowUser['last_name'] . "</td>";
                        echo "<td>" . $row['total_amount'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['payment_method'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";

                        echo "</tr>";
                    }
                } else {
                    // If no records are found, display a message
                    echo "<tr><td colspan='7'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</main>

<?php
include_once("./include/bottom.php");
?>
<script>
    $('.clickable-row').on('click', function() {
        var orderId = $(this).data('id'); // Get the order ID from the data attribute
        window.location.href = 'view-orders.php?orderId=' + orderId; // Redirect to the view-order page
    });
</script>
<script>
    function printData() {
        var containerContent = document.querySelector('main').outerHTML;
        var printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Print Container</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(containerContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>