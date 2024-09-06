<?php
include_once("./include/sidebar.php");
include_once("./php/connection.php")
?>

<?php
    $id = $_GET['editId'];
    $SQL = "SELECT * FROM redeemcode WHERE code_Id='$id'";
    $result = mysqli_query($conn,$SQL);
    if(mysqli_num_rows($result)<1)
    {
        header("location:redeem-code.php");
    }
    else
    {
        $row = mysqli_fetch_assoc($result);
    }
?>
<main>
    <div class="header">
        <div class="left">
            <h1>Edit Redeem</h1>
        </div>
    </div>

    <div class="add-form">
        <form id="myForm" class="add-new-form" >
            <div class="form-group">
                <label for="cname">Code Name</label>
                <input type="text" name="cname" id="cname" value="<?php echo $row['code'] ?>">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" name="price" id="price" value="<?php echo $row['price'] ?>">
            </div>
            <div class="form-group">
                <label for="cd">Expiry Date</label>
                <?php 
                    $dbDate = $row['expires_at'];
                    $dateOnly = explode(' ',$dbDate)[0];
                    ?>
                <input type="date" name="date" id="cd" value="<?php echo $dateOnly ?>">
            </div>
            <div class="form-group">
                <label for="ru">Remaining Usage</label>
                <input type="text" name="ru" id="ru" value="<?php echo $row['remaining_Usage'] ?>">
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
        xhr.open('POST', 'php/edit-redeem.php', true);
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