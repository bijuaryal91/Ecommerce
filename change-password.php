<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");


if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
    exit();
}



?>

<div class="account-section">
    <div class="account-menu">
        <div class="profile-pic">
            <div class="profile-image">
                <label for="profilepic" class="label-container">
                    <img src="./products/1.jpeg" alt="Profile Image" class="profile-pic">
                    <div class="camera-icon">
                        <i class="bx bx-camera"></i>
                    </div>
                </label>
                <input type="file" name="profilepic" id="profilepic" style="display: none;">
            </div>
        </div>
        <div class="profile-links">
            <ul>
                <li><a href="./account.php"><i class='bx bx-user'></i><span>Profile</span></a></li>
                <li><a href="./address.php"><i class='bx bx-id-card'></i><span>Address</span></a></li>
                <li class="active"><a href="./change-password.php"><i class='bx bxs-key'></i><span>Change Password</span></a></li>
                <li><a href="./orders.php"><i class='bx bx-cart'></i><span>Orders</span></a></li>
                <li><a href="./bills.php"><i class='bx bx-file'></i><span>Bills</span></a></li>
                <li><a href="./gifts.php"><i class='bx bxs-coupon'></i><span>Redeem Codes</span></a></li>
                <li class="logout"><a href="./php/logout.php"><i class='bx bx-exit'></i><span>Logout</span></a></li>
            </ul>
        </div>
    </div>
    <div class="account-content">
       
        <div class="profile-details">
            <div class="profile-details-heading">
                <i class="bx bxs-key"></i>
                <p>Change Password</p>
            </div>
            <div class="profile-details-inputs">
                <form action="#" method="post">
                    <div class="personal-details">
                        <div class="form-group">
                            <label for="opassword">Old Password</label>
                            <input type="password" id="opassword" name="opassword">
                        </div>
                    </div>
                    <div class="ep" style="flex-direction: column;">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="cpassword">Confirm Password</label>
                            <input type="password" id="cpassword" name="cpassword">
                        </div>
                    </div>
                    <div class="error-message">h</div>
                    <button type="submit" class="btn" name="submit">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.title = "Change Password - " + document.title;
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>