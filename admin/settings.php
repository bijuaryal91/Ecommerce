<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>

<?php
    $id =  $_SESSION['admin_user_id'];
    $sql = "SELECT * FROM admin WHERE id=".$id;
    $row=mysqli_fetch_assoc(mysqli_query($conn,$sql));
    
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Settings</h1>
        </div>
    </div>

    <div class="add-form" style="display: flex;justify-content:space-around;gap:20px;flex-wrap:wrap;">
        <form id="myForm" class="add-new-form"  style="width:40%">
        <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" >
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" name="cpassword" id="cpassword" >
                <input type="hidden" name="hp" value="<?php echo $id ?>">
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
        xhr.open('POST', 'php/update-admin.php', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Request was successful
                    const response = xhr.response;
                    if (response === "success") {
                        location.href = "settings.php";
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