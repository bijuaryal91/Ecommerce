<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
if (isset($_SESSION['user_status'])) {
    header("location:account.php");
    exit();
}
?>
<div class="signup-page">
    <div class="banner">
        <img src="./banners/login.png" alt="">
    </div>
    <div class="form">
        <div class="form-heading">
            <h2>Forgot Password</h2>
            <p></p>
        </div>
        <form id="userLogin" class="signup-form" method="POST">
            <div class="form-group">
                <label for="email">Enter Your Email *</label>
                <input type="text" name="email" id="email" placeholder="Enter Email">
            </div>
            <div class="error-message hidden">
                This is an error.
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" class=" submitbtn btn btn-fluid">
            </div>
        </form>
        <div class="horizontal-line"></div>
        <div class="form-alternative">
            Want to log in ? <a href="login.php">Log in</a>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        document.title = "Forgot Password - " + document.title;
    

        // Form validation
        document.querySelector(".signup-form").addEventListener("submit", (event) => {
            event.preventDefault();
            const form = event.target;
            const email = form.querySelector("#email").value.trim();
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
            if (!email) {
                showError("Email should not be empty!");
                valid = false;
                return false;
            }

            // Email validation
            const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!email || !emailRegex.test(email)) {
                showError("Please enter a valid email address.");
                valid = false;
                return; // Stop further validation
            }

            if (valid) {
                const form = document.querySelector("#userLogin");
                const submitBtn = document.querySelector('.submitbtn');
                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "php/forgot-password.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = xhr.response;
                            if (response === "success") {
                               
                                location.href = "verify-otp.php";
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