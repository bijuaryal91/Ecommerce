<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Users</h1>
        </div>
    </div>

    <div class="container">
        <!-- Search Bar -->
        <?php

        // Query to fetch data from the 'categories' table
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        ?>

        <!-- Data Table -->
        <div class="print-div">
            <table id="example" class="display responsive nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>Users Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any records in the result
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row of data
                        while ($row = mysqli_fetch_assoc($result)) {
                            $statusIcon = $row['status'] == 'active' ? 'bx-lock-alt' : 'bx-lock-open-alt';

                            echo "<tr>";
                            echo "<td>" . $row['user_id'] . "</td>";
                            echo "<td>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['phone_number'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td class='actions'>
                            <a href='./php/change-user-status.php?id=" . $row['user_id'] . "'> <i class='bx " . $statusIcon . " edit'></i> </a>
                        </td>";
                            echo "</tr>";
                        }
                    } else {
                        // If no records are found, display a message
                        echo "<tr><td colspan='6'>No Users found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="add-new-button">

            <button class="add-new add-button">Click Here To Print</button>
        </div>
    </div>




</main>

<script>
    document.querySelector('.add-button').addEventListener("click", () => {
        var containerContent = document.querySelector('table').outerHTML;
        var printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Print Container</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(containerContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    })
</script>
<script src="./js/datatable.js"></script>
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
<?php
include_once("./include/bottom.php");


?>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>