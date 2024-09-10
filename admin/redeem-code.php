<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Redeem Codes</h1>
        </div>
    </div>

    <div class="container">
        <!-- Search Bar -->
        <?php
     
        // Query to fetch data from the 'categories' table
        $sql = "SELECT * FROM redeemcode";
        $result = mysqli_query($conn, $sql);
        ?>

        <!-- Data Table -->
        <table id="example" class="display responsive nowrap" style="width:100%;">
            <thead>
                <tr>
                    <th>Code Id</th>
                    <th>Code</th>
                    <th>Price</th>
                    <th>Expires_at</th>
                    <th>Remaining Usage</th>
                    <th>Visibility</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any records in the result
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each row of data
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['code_Id'] . "</td>";
                        echo "<td>" . $row['code'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['expires_at'] . "</td>";
                        echo "<td>" . $row['remaining_Usage'] . "</td>";
                        echo "<td>" . $row['visibility'] . "</td>";
                        echo "<td class='actions'>
                        <a href='./edit-redeem.php?editId=". $row['code_Id'] ."'><i class='bx bx-edit-alt edit'></i></a>
                        <a href='./php/delete-redeem.php?deleteId=". $row['code_Id'] ."'><i class='bx bx-trash delete'></i></a>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    // If no records are found, display a message
                    echo "<tr><td colspan='6'>No Codes found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="add-new-button">

            <button class="add-new add-button">Add New Code</button>
        </div>
    </div>




</main>

<script>
    document.querySelector('.add-button').addEventListener("click",()=>{
        location.href="add-redeem.php";
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
