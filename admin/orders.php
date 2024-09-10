<?php
include_once("./include/sidebar.php");
include_once('./php/connection.php');
?>


<main>
    <div class="header">
        <div class="left">
            <h1>Orders</h1>
        </div>
        <a href="#" class="report" onclick="printOrders()">
            <i class='bx bx-printer'></i>
            <span>Print</span>
        </a>
    </div>


    <div class="container">
        <!-- Search Bar -->
        <?php

        // Query to fetch data from the 'categories' table
        $sql = "SELECT * FROM orders";
        $result = mysqli_query($conn, $sql);
        ?>

        <!-- Data Table -->
        <table id="example" class="display responsive nowrap" style="width:100%;">
            <thead>
                <tr>
                    <th>Order Id</th>
                    <th>Customer Name</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Action</th>
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
                        $rowUser = mysqli_fetch_assoc(mysqli_query($conn,$userSql));
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $rowUser['first_name'] ." ". $rowUser['last_name'] . "</td>";
                        echo "<td>" . $row['total_amount'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['payment_method'] . "</td>";
                        echo "<td>" . $row['order_date'] . "</td>";
                        echo "<td class='actions'>
                         <a href='./php/view-order.php?orderId=" . $row['order_id'] . "'><i class='fa fa-eye edit'></i></a>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    // If no records are found, display a message
                    echo "<tr><td colspan='7'>No categories found</td></tr>";
                }
                ?>
            </tbody>
        </table>
       
    </div>







</main>
<script>
    function printOrders() {
        var containerContent = document.querySelector('table').outerHTML;
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
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        lengthChange: true
    });
});

</script>
</html>