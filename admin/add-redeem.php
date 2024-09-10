<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Add Redeem</h1>
        </div>
    </div>

    <div class="add-form">
        <form id="myForm" class="add-new-form" >
            <div class="form-group">
                <label for="cname">Code Name</label>
                <input type="text" name="cname" id="cname">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price">
            </div>
            <div class="form-group">
                <label for="cd">Expiry Date</label>
                <input type="date" name="ed" id="cd">
            </div>
            <div class="form-group">
                <label for="remaining">Remaining</label>
                <input type="text" name="remaining" id="remaining">
            </div>
            <div class="form-group">
                <label for="visibility">Visibility</label>
                <select name="visibility" id="visibility">
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
            <div class="error-text hidden">h</div>
            <button name="submit" onclick="submitForm()">Add</button>
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
        xhr.open('POST', 'php/add-redeem.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Request was successful
                    const response = xhr.response;
                    if (response === "success") {
                        location.href = "redeem-code.php";
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