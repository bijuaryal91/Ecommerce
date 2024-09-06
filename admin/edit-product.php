<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>

<?php
$id = $_GET['editId'];
$SQL = "SELECT * FROM products WHERE product_id='$id'";
$result = mysqli_query($conn, $SQL);
if (mysqli_num_rows($result) < 1) {
    header("location:products.php");
} else {
    $row = mysqli_fetch_assoc($result);
}
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Edit Product</h1>
        </div>
    </div>

    <div class="add-form">
        <form id="myForm" class="add-new-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="cname">Product Name</label>
                <input type="text" name="pname" id="cname" value="<?php echo $row['name'] ?>">
            </div>
            <div class="form-group">
                <label for="short">Short Description</label>
                <input type="text" name="short" id="short" value="<?php echo $row['short_description'] ?>">
            </div>
            <div class="form-group">
                <label for="long">Long Description</label>
                <input type="text" name="long" id="long" value="<?php echo $row['long_description'] ?>">
            </div>
            <div class="form-group category">
                <label for="category">Category</label>
                <select name="category" id="category">
                    <?php
                    $sql2 = "SELECT * FROM categories 
                   ORDER BY 
                   CASE WHEN category_id = " . $row['category_id'] . " THEN 0 ELSE 1 END, 
                   category_id";

                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo "<option value=" . $row2['category_id'] . ">" . $row2['category_name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" value="<?php echo $row['price'] ?>">
            </div>
            <div class="form-group">
                <label for="material">Material</label>
                <input type="text" name="material" id="material" value="<?php echo $row['material'] ?>">
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" name="weight" id="weight" value="<?php echo $row['weight'] ?>">
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" name="stock" id="stock" value="<?php echo $row['stock_quantity'] ?>">
                <input type="hidden" value="<?php echo $id ?>" name="id">
            </div>
            <div class="error-text hidden">h</div>
            <button name="submit" onclick="submitForm()">Update</button>
        </form>
    </div>

</main>
<script>
    function submitForm() {
        event.preventDefault();
        const errorText = document.querySelector('.error-text');

        const form = document.getElementById('myForm');
        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/edit-product.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Request was successful
                    const response = xhr.response;
                    if (response === "success") {
                        location.href = "products.php";
                    } else {
                        errorText.innerHTML = response;
                        errorText.classList.remove("hidden");
                    }
                } else {
                    // Request failed
                    errorText.innerHTML = 'Error occurred.';
                    errorText.classList.remove("hidden");
                }
            }
        };

        // Convert FormData to JSON
        xhr.send(formData);
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
<?php
include_once("./include/bottom.php");


?>