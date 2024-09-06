<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php");

$SQL = "SELECT * FROM categories ORDER BY category_name ASC";
$result = mysqli_query($conn,$SQL);

?>
<main>
    <div class="header">
        <div class="left">
            <h1>Add Products</h1>
        </div>
    </div>

    <div class="add-form">
        <form id="myForm" class="add-new-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="cname">Product Name</label>
                <input type="text" name="pname" id="cname">
            </div>
            <div class="form-group">
                <label for="short">Short Description</label>
                <input type="text" name="short" id="short">
            </div>
            <div class="form-group">
                <label for="long">Long Description</label>
                <input type="text" name="long" id="long">
            </div>
            <div class="form-group category">
                <label for="category">Category</label>
                <select name="category" id="category">
                    <?php
                        if(mysqli_num_rows($result) > 0)
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                                echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price">
            </div>
            <div class="form-group">
                <label for="material">Material</label>
                <input type="text" name="material" id="material">
            </div>
            <div class="form-group">
                <label for="weight">Weight</label>
                <input type="text" name="weight" id="weight">
            </div>
            <div class="form-group">
                <label for="mainIMG">Main Image</label>
                <input type="file" name="mimg" id="mainIMG" accept="image/*">
            </div>
            <div class="form-group">
                <label for="oIMG">Other Images</label>
                <input type="file" name="oimg[]" id="oIMG" accept="image/*" multiple>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" name="stock" id="stock">
            </div>
            <div class="error-text hidden">h</div>
            <button name="submit" onclick="submitForm()">Add</button>
        </form>
    </div>

</main>
<script>
    document.getElementById('mainIMG').addEventListener('change',function(){
        const files = this.files;
        let valid = true;
        // Check if all files are images
        if (valid) {
            for (let i = 0; i < files.length; i++) {
                if (!files[i].type.startsWith('image/')) {
                    alert('Please select only image files.');
                    this.value = ''; // Clear the input
                    break;
                }
            }
        }
    })
    document.getElementById('oIMG').addEventListener('change', function() {
        const files = this.files;
        let valid = true;

        // Check if the number of files exceeds the limit
        if (files.length > 3) {
            alert('You can only select up to 3 images.');
            this.value = ''; // Clear the input
            valid = false;
        }

        // Check if all files are images
        if (valid) {
            for (let i = 0; i < files.length; i++) {
                if (!files[i].type.startsWith('image/')) {
                    alert('Please select only image files.');
                    this.value = ''; // Clear the input
                    break;
                }
            }
        }
    });

    function submitForm() {
        event.preventDefault();
        const errorText = document.querySelector('.error-text');

        const form = document.getElementById('myForm');
        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/add-product.php', true);
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
    document.querySelector('.add-button').addEventListener("click", () => {
        location.href = "add-category.php";
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