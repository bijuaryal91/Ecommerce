<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");

if (!isset($_COOKIE['isMatched']) || !isset($_COOKIE['email'])) {
    header("location:forgot-password.php");
}
?>
<div class="signup-page">
    <div class="banner">
        <img src="./banners/login.png" alt="">
    </div>
    <div class="form">
        <div class="form-heading">
            <h2>Create Password</h2>
            <p></p>
        </div>
        <form id="userLogin" class="signup-form" method="POST">
            <div class="form-group">
                <label for="password">Enter Password *</label>
                <input type="password" name="password" id="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password *</label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
            </div>
            <div class="error-message hidden">
                This is an error.
            </div>
            <div class="form-group">
                <input type="submit" value="Change Password" class=" submitbtn btn btn-fluid">
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.title = "Create Password - " + document.title;


        // Form validation
        document.querySelector(".signup-form").addEventListener("submit", (event) => {
            event.preventDefault();
            const form = event.target;
            const password = form.querySelector("#password").value.trim();
            const cpassword = form.querySelector("#cpassword").value.trim();
            const errorMessage = form.querySelector(".error-message");

            let valid = true;

            // Clear previous error message

            // Function to add error messages
            const showError = (message) => {
                errorMessage.textContent = message;
                errorMessage.classList.remove("hidden");
                valid = false;
            };

            // Empty validation
            if (!password || !cpassword) {
                showError("All fields are required!");
                valid = false;
                return false;
            }

            // Email validation
            if (password.length < 8) {
                showError("Password must be 8 character long!");
                valid = false;
                return false;
            }
            if (password !== cpassword) {
                showError("Confirm password must be matched with password");
                valid = false;
                return false;
            }

            if (valid) {
                const form = document.querySelector("#userLogin");
                const submitBtn = document.querySelector('.submitbtn');
                submitBtn.value="Loading...";
                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "php/change-forgot-password.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = xhr.response;
                            if (response === "success") {

                                location.href = "login.php";
                            } else {
                                showError(response);
                            }
                        } else {
                            showError("Error Occured");
                        }
                    }
                };
                xhr.send(formData);
            }
        });
    });
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>