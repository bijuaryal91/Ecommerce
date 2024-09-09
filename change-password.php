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
                    <img src="./users/default.jpg" alt="Profile Image" class="profile-pic" id="profile-img">
                    <div class="camera-icon">
                        <i class="bx bx-camera"></i>
                    </div>
                </label>
                <input type="file" name="profilepic" id="profilepic" style="display: none;" accept="image/*">
            </div>

            <script>
                var formData;
                document.getElementById('profilepic').addEventListener('change', function() {
                    const file = this.files[0];

                    // Check if a file is selected
                    if (file) {
                        // Validate file type
                        const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                        if (validImageTypes.includes(file.type)) {
                            // Create FormData and append the file
                            formData = new FormData();
                            formData.append('profilepic', file);

                            // Send XHR request to update profile_pic
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', './php/update-profile-pic.php', true);

                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    // Handle success response
                                    alert('Profile picture updated successfully!');
                                } else {
                                    // Handle error response
                                    alert(xhr.response);
                                }
                            };

                            xhr.onerror = function() {
                                alert('Request failed. Please try again.');
                            };

                            // Send the FormData
                            xhr.send(formData);
                        } else {
                            // Display an error message if the file is not an image
                            alert('Please select a valid image file (jpg, png, gif).');
                            // Clear the input value to allow the user to select a file again
                            this.value = '';
                        }
                    }
                });
                setInterval(() => {
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "./php/get-profile-pic.php", true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                const response = JSON.parse(xhr.response);
                                if (response.success) {
                                    document.getElementById("profile-img").src = "./users/" + response.profile_pic;
                                }
                            }
                        }
                    };
                    xhr.send(formData);
                }, 500);
            </script>

        </div>
        <div class="profile-links">
            <ul>
                <a href="./account.php">
                    <li><i class='bx bx-user'></i><span>Profile</span></li>
                </a>
                <a href="./address.php">
                    <li><i class='bx bx-id-card'></i><span>Address</span></li>
                </a>
                <a href="./change-password.php">
                    <li class="active"><i class='bx bxs-key'></i><span>Change Password</span></li>
                </a>
                <a href="./orders.php">
                    <li><i class='bx bx-cart'></i><span>Orders</span></li>
                </a>
                <a href="./gifts.php">
                    <li><i class='bx bxs-coupon'></i><span>Redeem Codes</span></li>
                </a>
                <a href="./php/logout.php">
                    <li class="logout"><i class='bx bx-exit'></i><span>Logout</span></li>
                </a>
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