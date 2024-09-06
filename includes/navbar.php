<?php
session_start();
$connnnnnnn = mysqli_connect("localhost", "root", "", "rk_db");
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$cart_item_count = 0;
$wishlist_item_count = 0;

if ($user_id > 0) {
    // Fetch the cart ID for the user
    $cart_sql = "SELECT cart_id FROM carts WHERE user_id = '$user_id'";
    $cart_result = mysqli_query($connnnnnnn, $cart_sql);
    
    if ($cart_result && mysqli_num_rows($cart_result) > 0) {
        $cart = mysqli_fetch_assoc($cart_result);
        $cart_id = $cart['cart_id'];

        // Get the count of unique products in the cart
        $count_sql = "SELECT COUNT(DISTINCT product_id) as unique_product_count 
                      FROM cart_items 
                      WHERE cart_id = '$cart_id'";
        $count_result = mysqli_query($connnnnnnn, $count_sql);

        if ($count_result) {
            $count_row = mysqli_fetch_assoc($count_result);
            $cart_item_count = $count_row['unique_product_count'];
        }
    }

    // Fetch the wishlist item count for the user
    $wishlist_sql = "SELECT wishlist_id FROM wishlists WHERE user_id = '$user_id'";
    $wishlist_result = mysqli_query($connnnnnnn, $wishlist_sql);
    
    if ($wishlist_result && mysqli_num_rows($wishlist_result) > 0) {
        $wishlist = mysqli_fetch_assoc($wishlist_result);
        $wishlist_id = $wishlist['wishlist_id'];

        $items_sql = "SELECT COUNT(*) as wishlist_count FROM wishlist_items WHERE wishlist_id = '$wishlist_id'";
        $items_result = mysqli_query($connnnnnnn, $items_sql);

        if ($items_result) {
            $items_row = mysqli_fetch_assoc($items_result);
            $wishlist_item_count = $items_row['wishlist_count'];
        }
    }
} else {
    // Set static values if user_id is 0
    $cart_item_count = 0;
    $wishlist_item_count = 0;
}
?>

<div class="navbar">
    <input type="checkbox" id="check" />
    <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
    </label>
    <div class="nav-logo">
        <a href="index.php">
            <img src="logo.png" alt="Logo." />
        </a>
    </div>
    <div class="search-bar">
        <input type="search" name="navsearch" placeholder="Search Products" />
        <button>
            <i class="fa fa-search"></i>
        </button>
    </div>
    <div class="nav-links">
        <div class="find-us links">
            <a href="contact.php"> <i class="bx bx-map"></i> <span>Find us</span> </a>
        </div>
        <div class="cart links">
            <a href="cart.php">
                <div class="cart-icon icon">
                    <i class="bx bx-shopping-bag"></i> <span class="counter"><?php echo $cart_item_count; ?></span>
                </div>
                <span>Cart</span>
            </a>
        </div>

        <div class="wishlist links">
            <a href="wishlist.php">
                <div class="wishlist-icon icon">
                    <i class="bx bx-heart"></i> <span class="counter"><?php echo $wishlist_item_count; ?></span>
                </div>
                <span>wishlist</span>
            </a>
        </div>
        <div class="myaccount links">
            <?php
            $account = isset($_SESSION['user_status']) ? $_SESSION['name'] : "Account";
            ?>
            <a href="account.php">
                <i class="bx bx-user"></i>
                <span><?php echo $account; ?></span>
            </a>
        </div>
    </div>

    <div class="sub-nav">
        <div class="mobile-nav">
            <div class="sub-heading">
                <h1>Welcome to Rk Stores</h1>
            </div>
            <div class="mobile-links">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="shop.php">Shop</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="account.php">My Account</a></li>
                    <li><a href="cart.php">My Cart</a></li>
                    <li><a href="wishlist.php">My Wishlist</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="tab-slider">
    <ul>
        <li><a href="shop.php">All Jewellery</a></li>
        <li><a href="shop.php?category=gold">Gold</a></li>
        <li><a href="shop.php?category=silver">Silver</a></li>
        <li><a href="shop.php?category=diamond">Diamond</a></li>
        <li><a href="shop.php">Collections</a></li>
        <li><a href="git-cards.php">Gift Cards</a></li>
        <li><a href="shop.php">Explore All</a></li>
    </ul>
</div>
