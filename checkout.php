<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");
if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
}
if ($_COOKIE['isCameFromCart'] != "true") {
    header("location:cart.php");
}
$user_id = $_SESSION['user_id'];

// Fetch cart details
$cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_sql);
$cart_id = mysqli_fetch_assoc($cart_result)['cart_id'] ?? 0;

// Get cart items
$items_sql = "SELECT p.product_id, p.name, p.price, p.main_image_url, ci.quantity 
              FROM cart_items ci 
              JOIN products p ON ci.product_id = p.product_id
              WHERE ci.cart_id = '$cart_id'";
$items_result = mysqli_query($conn, $items_sql);

$total_cost = 0;
$discountPrice = 0;
if (mysqli_num_rows($items_result) > 0) {
    while ($row = mysqli_fetch_assoc($items_result)) {
        $product_total = $row['price'] * $row['quantity'];
        $total_cost += $product_total;
    }
}

?>

<div class="billing-page">
    <?php
    $billingDetailsSQL = "SELECT * FROM users WHERE user_id=" . $user_id;
    $resultB = mysqli_query($conn, $billingDetailsSQL);
    $rowB = mysqli_fetch_assoc($resultB);
    ?>
    <div class="billing-details">
        <div class="heading">Billing Details</div>
        <form class="billing-form">
            <div class="form-group">
                <label for="fname">Name*</label>
                <input type="text" name="name" id="name" value="<?php echo $rowB['first_name'] . ' ' . $rowB['last_name'] ?>">
            </div>
            <div class="form-group">
                <label for="cname">Full Address*</label>
                <input type="text" name="address" id="cname" value="<?php echo $rowB['address'] ?>">
            </div>
            <div class="form-group">
                <label for="street">Street Address*</label>
                <input type="text" name="street" id="street" value="<?php echo $rowB['street'] ?>">
            </div>
            <div class="form-group">
                <label for="apart">Apartment, Floor</label>
                <input type="text" name="apart" id="apart" value="<?php echo $rowB['apartment'] ?>">
            </div>
            <div class="form-group">
                <label for="town">Town/City*</label>
                <input type="text" name="town" id="town" value="<?php echo $rowB['city'] ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number*</label>
                <input type="text" name="phone" id="phone" value="<?php echo $rowB['phone_number'] ?>">
            </div>
            <div class="form-group">
                <label for="email">Email Address*</label>
                <input type="text" name="email" id="email" value="<?php echo $rowB['email'] ?>" disabled>
            </div>
            <!-- <div class="error-message billing-error hidden">h</div> -->
            <div class="form-group agree">
                <input type="checkbox" name="saveData" id="save">
                <label for="save">Save Information for later</label>
            </div>
        </form>
    </div>
    <div class="billing-action">
        <div class="billing-products">
            <?php
            if (mysqli_num_rows($items_result) > 0) {
                mysqli_data_seek($items_result, 0); // Reset result pointer
                while ($row = mysqli_fetch_assoc($items_result)) {
                    $product_total = $row['price'] * $row['quantity'];
            ?>
                    <div class="billing-product">
                        <div class="product-name">
                            <img src="./admin/uploads/<?php echo $row['main_image_url'] ?>" alt="">
                            <div class="name"><?php echo $row['name'] ?> x <?php echo $row['quantity'] ?></div>
                        </div>
                        <div class="product-cost">Rs. <?php echo $product_total ?></div>
                    </div>
            <?php
                }
            }

            ?>
        </div>
        <div class="billing-costs">
            <div class="subtotal">
                <p>Subtotal</p>
                <p class="subt">RS. <?php echo $total_cost ?></p>
            </div>
            <div class="horizontal-line"></div>
            <div class="subtotal">
                <p>Shipping</p>
                <p>Free</p>
            </div>
            <div class="horizontal-line"></div>
            <div class="subtotal">
                <p>Discount</p>
                <p class="discounted">Rs. <?php echo $discountPrice ?></p>
            </div>
            <div class="horizontal-line"></div>
            <div class="subtotal">
                <p>Total: </p>
                <p class="totalp">RS. <?php echo $total_cost - $discountPrice ?></p>
            </div>
        </div>
        <div class="payment-method">
            <div class="stripe">
                <input type="radio" name="payment" id="stripe" value="stripe">
                <label for="stripe">Stripe</label>
            </div>
            <div class="cod">
                <input type="radio" name="payment" id="cod" value="cod">
                <label for="cod">Cash on delivery</label>
            </div>
        </div>
        <form id="redeemForm" class="coupon-code">
            <input type="text" name="coupon_code" placeholder="Coupon Code">
            <button type="button" class="btn redeemBtn">Redeem</button>
        </form>
        <div class="place-order">
            <button class="btn">Place Order</button>
        </div>
        <div class="error-message coupon-error hidden">Abui</div>
    </div>
</div>
<script>
    document.title = "Billing - " + document.title;
</script>
<script src="./js/checkoutV.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const redeemBtn = document.querySelector('.redeemBtn');
        const errorMessage = document.querySelector('.coupon-error');

        redeemBtn.addEventListener('click', () => {
            // Disable the button to prevent further clicks
            redeemBtn.disabled = true;
            redeemBtn.style.cursor = "not-allowed";
            const form = document.querySelector("#redeemForm");
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "./php/redeem_coupon.php", true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.status === "success") {
                                errorMessage.classList.add("hidden");
                                let subtotalElem = document.querySelector('.billing-costs .subt');
                                let subtotal = subtotalElem.textContent.replace('RS.', '');
                                const discountAmount = parseFloat(response.discount);
                                console.log(subtotal+" k");
                                // Check if the total after discount is less than 5000
                                if (subtotal - discountAmount >= 5000) {
                                    const discountElem = document.querySelector('.billing-costs .discounted');

                                    // Update discount and total costs
                                    discountElem.innerHTML = `Rs. ${discountAmount}`;
                                    console.log(discountElem.textContent);

                                    // Update the total amount
                                    const totalElem = document.querySelector('.billing-costs .totalp');
                                    totalElem.textContent = `Rs. ${subtotal - discountAmount}`;
                                } else {
                                    showError("You can't apply this coupon.");
                                    redeemBtn.disabled = false;
                                    redeemBtn.style.cursor = "default";
                                }

                            } else {
                                showError(response.message);
                                // Re-enable the button if there is an error
                                redeemBtn.disabled = false;
                                redeemBtn.style.cursor = "default";
                            }
                        } catch (e) {
                            showError("Invalid response format.");
                            // Re-enable the button if there is an error
                            redeemBtn.disabled = false;
                            redeemBtn.textContent = 'Redeem'; // Optional: reset button text
                        }
                    } else {
                        showError("Error Occurred");
                        // Re-enable the button if there is an error
                        redeemBtn.disabled = false;
                        redeemBtn.textContent = 'Redeem'; // Optional: reset button text
                    }
                }
            };

            xhr.send(formData);
        });

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.remove('hidden');
        }
    });
</script>


<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>