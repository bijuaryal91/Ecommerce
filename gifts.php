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
                    <li><i class='bx bxs-key'></i><span>Change Password</span></li>
                </a>
                <a href="./orders.php">
                    <li><i class='bx bx-cart'></i><span>Orders</span></li>
                </a>
                <a href="./gifts.php">
                    <li class="active"><i class='bx bxs-coupon'></i><span>Redeem Codes</span></li>
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
                <i class="bx bxs-coupon"></i>
                <p>Redeem Codes</p>
            </div>
            <!-- Search Bar -->
            <?php
            // Query to fetch data from the 'categories' table
            $sql = "SELECT * FROM redeemcode WHERE visibility='public' AND remaining_usage>0";

            $result = mysqli_query($conn, $sql);
            ?>

            <!-- Data Table -->
            <table id="example" class="display responsive nowrap" style="width:100%;text-align:center;">
                <thead>
                    <tr>
                        <th>S.N</th>
                        <th>Code</th>
                        <th>Amount</th>
                        <th>Expires At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any records in the result
                    if (mysqli_num_rows($result) > 0) {
                        $i = 1;
                        // Loop through each row of data
                        while ($row = mysqli_fetch_assoc($result)) {

                            echo "<tr>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row['code'] . "</td>";
                            echo "<td>" . $row['price'] . "</td>";
                            echo "<td>" . $row['expires_at'] . "</td>";


                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        // If no records are found, display a message
                        echo "<tr><td colspan='4'>No codes found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.title = "Orders - " + document.title;
</script>

<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#example').DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: false
        });

    });
</script>


<style>
    /* Hide the Next and Previous buttons */
    .dataTables_paginate .paginate_button.next,
    .dataTables_paginate .paginate_button.previous {
        display: none;
    }
</style>

<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>