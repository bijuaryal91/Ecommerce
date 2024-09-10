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
                    <li><i class='bx bx-user'></i><span>Profile</span></li>
                </a>
                <a href="./address.php">
                    <li class="active"><i class='bx bx-id-card'></i><span>Address</span></li>
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
    <div class="account-content">

        <div class="profile-details">
            <div class="profile-details-heading">
                <i class="bx bx-id-card"></i>
                <p>Address</p>
            </div>
            <?php
            $sql = "SELECT * FROM users WHERE user_id='$user_id'";
            $row=mysqli_fetch_assoc(mysqli_query($conn,$sql));
            ?>
            <div class="profile-details-inputs">
                <form onsubmit="changeAddress()" method="post" id="changeAddress">
                    <div class="personal-details">
                        <div class="form-group">
                            <label for="address">Address*</label>
                            <input type="text" id="address" name="address" value="<?php echo $row['address'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="street">Street*</label>
                            <input type="text" id="street" name="street" value="<?php echo $row['street'] ?>">
                        </div>
                    </div>
                    <div class="ep">
                        <div class="form-group">
                            <label for="apart">Apartment</label>
                            <input type="text" id="apart" name="apart" value="<?php echo $row['apartment'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="city">City*</label>
                            <input type="text" id="city" name="city" value="<?php echo $row['city'] ?>">
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
    document.title = "Address - " + document.title;
</script>
<script>
    function changeAddress() {
        event.preventDefault();
        const form = document.querySelector("#changeAddress");
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        const errorForm = document.querySelector("#changeAddress .error-message");
        xhr.open("POST", "php/change-address.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    const response = xhr.response;
                    if (response === "success") {
                        errorForm.classList.add("hidden");
                        alert("Address changed Successfully");
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