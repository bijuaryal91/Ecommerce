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
            <h2>Log In</h2>
            <p></p>
        </div>
        <form id="userLogin" class="signup-form" method="POST">
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="text" name="email" id="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <div class="password-field">
                    <input type="password" id="password" name="password" placeholder="Enter Password">
                    <i class="fa-regular fa-eye-slash"></i>
                </div>
            </div>
            <div class="error-message hidden">
                This is an error.
            </div>
            <div class="form-group">
                <input type="submit" value="Log In" class="btn btn-fluid">
            </div>
        </form>
        <div class="horizontal-line"></div>
        <div class="form-alternative">
            Don't have an account? <a href="signup.php">Sign Up</a>
        </div>
        <div class="form-alternative">
            <a href="forgot-password.php">Forgot Password?</a>
        </div>
    </div>
</div>
<script src="./js/signinValidation.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>