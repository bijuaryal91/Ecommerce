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
                <li class="active"><a href="./address.php"><i class='bx bx-id-card'></i><span>Address</span></a></li>
                <li><a href="./change-password.php"><i class='bx bxs-key'></i><span>Change Password</span></a></li>
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
                <i class="bx bx-id-card"></i>
                <p>Address</p>
            </div>
            <div class="profile-details-inputs">
                <form action="#" method="post">
                    <div class="personal-details">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address">
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" id="street" name="street">
                        </div>
                    </div>
                    <div class="ep">
                        <div class="form-group">
                            <label for="apart">Apartment</label>
                            <input type="text" id="apart" name="apart">
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city">
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
    document.title = "Address - " + document.title;
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>