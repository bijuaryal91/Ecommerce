<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Category</h1>
        </div>
    </div>

    <div class="container">
        <!-- Search Bar -->
        <?php
     
        // Query to fetch data from the 'categories' table
        $sql = "SELECT * FROM categories";
        $result = mysqli_query($conn, $sql);
        ?>

        <!-- Data Table -->
        <table id="example" class="display responsive nowrap" style="width:100%;">
            <thead>
                <tr>
                    <th>Category Id</th>
                    <th>Name</th>
                    <th>Description</th>
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
                        echo "<td>" . $row['category_id'] . "</td>";
                        echo "<td>" . $row['category_name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td class='actions'>
                        <a href='./edit-category.php?editId=". $row['category_id'] ."'><i class='bx bx-edit-alt edit'></i></a>
                        <a href='./php/delete-category.php?deleteId=". $row['category_id'] ."'><i class='bx bx-trash delete'></i></a>
                      </td>";
                        echo "</tr>";
                    }
                } else {
                    // If no records are found, display a message
                    echo "<tr><td colspan='4'>No categories found</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="add-new-button">

            <button class="add-new add-button">Add New Category</button>
        </div>
    </div>




</main>

<script>
    document.querySelector('.add-button').addEventListener("click",()=>{
        location.href="add-category.php";
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
