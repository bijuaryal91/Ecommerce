<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php");
?>


<main>
    <div class="header">
        <div class="left">
            <h1>Dashboard</h1>
        </div>
        <a href="#" class="report">
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

        $sql = "SELECT SUM(total_amount) AS total_sum FROM orders";
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
                    Rs. <?php echo number_format($total_sum, 2); ?>
                </h3>
                <p>Total Sales</p>
            </span>
        </li>


    </ul>
    <!-- End of Insights -->



</main>

<?php
include_once("./include/bottom.php");
?>