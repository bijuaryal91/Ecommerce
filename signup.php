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
            <h2>Create an account</h2>
            <p></p>
        </div>
        <form id="signupForm" class="signup-form" method="POST">
            <div class="user-name">
                <div class="form-group">
                    <label for="fname">First Name *</label>
                    <input type="text" name="fname" id="fname" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                    <label for="lname">Last Name *</label>
                    <input type="text" name="lname" id="lname" placeholder="Enter Last Name">
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="text" name="email" id="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="phone">Phone *</label>
                <input type="text" name="phone" id="phone" placeholder="Enter Phone Number">
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <div class="password-field">
                    <input type="password" name="password" id="password" placeholder="Enter Password">
                    <i class="fa-regular fa-eye-slash"></i>
                </div>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password *</label>
                <div class="password-field">
                    <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
                    <i class="fa-regular fa-eye-slash"></i>
                </div>
            </div>
            <div class="error-message hidden">
                This is an error.
            </div>
            <div class="form-group">
                <input type="submit" value="Sign Up" class="btn btn-fluid">
            </div>
        </form>
        <div class="horizontal-line"></div>
        <div class="form-alternative">
            Already have an account? <a href="login.php">Sign In</a>
        </div>
        
    </div>
</div>
<script src="./js/signupValidation.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>