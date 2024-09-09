<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Products</h1>
        </div>
    </div>

    <div class="container">
        <!-- Search Bar -->
        <?php
     
        // Query to fetch data from the 'categories' table
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        ?>

        <!-- Data Table -->
        <table id="example" class="display responsive nowrap" style="width:100%;">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <!-- <th>Description</th> -->
                    <th>Category</th>
                    <th>Price</th>
                    <th>Material</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any records in the result
                if (mysqli_num_rows($result) > 0) {
                    // Loop through each row of data
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sqlc = "SELECT * FROM categories WHERE category_id=".$row['category_id'];
                        $rowc=mysqli_fetch_assoc(mysqli_query($conn,$sqlc));
                        echo "<tr>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>".$rowc['category_name']."</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['material'] . "</td>";
                        echo "<td>" . $row['stock_quantity'] . "</td>";
                        echo "<td class='actions'>
                        <a href='./edit-product.php?editId=". $row['product_id'] ."'><i class='bx bx-edit-alt edit'></i></a>
                        <a href='./php/delete-product.php?deleteId=". $row['product_id'] ."'><i class='bx bx-trash delete'></i></a>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    // If no records are found, display a message
                    echo "<tr><td colspan='8'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="add-new-button">

            <button class="add-new add-button">Add New Product</button>
        </div>
    </div>




</main>

<script>
    document.querySelector('.add-button').addEventListener("click",()=>{
        location.href="add-product.php";
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

