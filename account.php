<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");


if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
    exit();
}


$user_id = $_SESSION['user_id'];
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
                    <li class="active"><i class='bx bx-user'></i><span>Profile</span></li>
                </a>
                <a href="./address.php">
                    <li><i class='bx bx-id-card'></i><span>Address</span></li>
                </a>
                <a href="./change-password.php">
                    <li><i class='bx bxs-key'></i><span>Change Password</span></li>
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
    <?php
    $detailsSql = "SELECT * FROM redeemcode WHERE visibility='public'";
    $result = mysqli_query($conn, $detailsSql);
    ?>
    <div class="account-content">
        <div class="account-cards">
            <div class="gifts cards">
                <div class="account-card-icon"><i class='bx bxs-coupon'></i></div>
                <div class="account-card-content">
                    <div class="account-heading">Gifts</div>
                    <div class="account-count"><?php echo mysqli_num_rows($result) ?></div>
                </div>
            </div>
            <?php

            $detailsSql = "SELECT * FROM wishlists WHERE user_id='$user_id'";
            $result = mysqli_query($conn, $detailsSql);
            $row = mysqli_fetch_assoc($result);
            $wishlistId = isset($row['wishlist_id']) ? $row['wishlist_id'] : $row['wishlist_id'];

            $aSql = "SELECT * FROM wishlist_items WHERE wishlist_id='$wishlistId'";
            $aResult = mysqli_query($conn, $aSql);
            ?>
            <div class="wishlist cards">
                <div class="account-card-icon"><i class='bx bxs-heart'></i></div>
                <div class="account-card-content">
                    <div class="account-heading">Wishlist</div>
                    <div class="account-count"><?php echo mysqli_num_rows($aResult) ?></div>
                </div>
            </div>
            <?php

            $detailsSql = "SELECT * FROM carts WHERE user_id='$user_id'";
            $result = mysqli_query($conn, $detailsSql);
            $row = mysqli_fetch_assoc($result);
            $cartId = isset($row['cart_id']) ? $row['cart_id'] : '';

            $aSql = "SELECT * FROM cart_items WHERE cart_id='$cartId'";
            $aResult = mysqli_query($conn, $aSql);
            ?>
            <div class="cart cards">
                <div class="account-card-icon"><i class='bx bxs-cart'></i></div>
                <div class="account-card-content">
                    <div class="account-heading">Cart</div>
                    <div class="account-count"><?php echo mysqli_num_rows($aResult) ?></div>
                </div>
            </div>
        </div>
        <div class="profile-details">
            <div class="profile-details-heading">
                <i class="bx bx-user"></i>
                <p>Profile Details</p>
            </div>
            <?php 
                $sql = "SELECT * FROM users WHERE user_id='$user_id'";
                $row = mysqli_fetch_assoc(mysqli_query($conn,$sql));
            ?>
            <div class="profile-details-inputs">
                <form action="#" method="post" id="changeDetails" onsubmit="changeDetails()">
                    <div class="personal-details">
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" id="fname" name="fname" value="<?php echo $row['first_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" id="lname" name="lname" value="<?php echo $row['last_name'] ?>">
                        </div>
                    </div>
                    <div class="ep">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $row['email'] ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="<?php echo $row['phone_number'] ?>">
                        </div>
                    </div>
                    <div class="error-message hidden">h</div>
                    <button type="submit" class="btn" name="submit">Save Changes</button>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.title = "My Account - " + document.title;
</script>
<script>
    function changeDetails() {
        event.preventDefault();
        const form = document.querySelector("#changeDetails");
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        const errorForm = document.querySelector("#changeDetails .error-message");
        xhr.open("POST", "php/change-account.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    if (response === "success") {
                        errorForm.classList.add("hidden");
                        alert("Details changed Successfully");
                        window.location.reload();
                    } else {
                        errorForm.classList.remove("hidden");
                        errorForm.innerHTML = response;
                    }
                } else {
                    errorForm.classList.remove("hidden");
                    errorForm.innerHTML = "Error Occured";
                }
            }
        };
        xhr.send(formData);
    }
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>