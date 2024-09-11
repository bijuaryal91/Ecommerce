<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");
if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
}
$userId = $_SESSION['user_id'];
?>

<div class="wishlist-section">
    <?php

    $sql = "SELECT * FROM wishlists WHERE user_id=" . $userId;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);
        $wishlist_id = $row['wishlist_id'];
        $sql = "SELECT * FROM wishlist_items WHERE wishlist_id=" . $wishlist_id;
        $result = mysqli_query($conn, $sql);
    ?>
        <div class="wishlist-heading">
            <span>Wishlist (<?php echo mysqli_num_rows($result) ?>)</span>
            <form action="php/move-all-to-cart.php" method="post">
                <input type="hidden" name="wishlist_id" value="<?php echo $wishlist_id; ?>">
                <button type="submit" class="move-to-bag-button">Move All To Bag</button>
            </form>
        </div>
        <div class="product-list">
            <?php

            while ($row = mysqli_fetch_assoc($result)) {
                $productId = $row['product_id'];
                $sql1 = "SELECT * FROM products WHERE product_id=" . $productId;
                $result1 = mysqli_query($conn, $sql1);
                while ($row1 = mysqli_fetch_assoc($result1)) {
            ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="admin/uploads/<?php echo $row1['main_image_url']; ?>" alt="">
                            <a href="php/delete-wishlist.php?productId=<?php echo $row1['product_id'] ?>"><i class='bx bx-trash'></i></a>
                        </div>
                        <div class="product-card-details">
                            <h1><?php echo $row1['name']; ?></h1>

                            <div class="price">Rs. <?php echo $row1['price']; ?></div>
                            <?php
                            $product_id = $row1['product_id'];

                            $ratingQuery = "SELECT rating FROM reviews WHERE product_id = '$product_id'";
                            $ratingResult = mysqli_query($conn, $ratingQuery);

                            $ratings = [];
                            while ($ratingRow = mysqli_fetch_assoc($ratingResult)) {
                                $ratings[] = $ratingRow['rating'];
                            }

                            // Calculate total reviews and average rating
                            $total_reviews = count($ratings);
                            $average_rating = $total_reviews > 0 ? array_sum($ratings) / $total_reviews : 0;

                            // Round the average rating to the nearest half
                            $rounded_rating = round($average_rating * 2) / 2;
                            ?>
                            <div class="rating">
                                <ul>
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($rounded_rating >= $i) {
                                            // Full star
                                            echo "<li><i class='bx bxs-star checked'></i></li>";
                                        } elseif ($rounded_rating >= $i - 0.5) {
                                            // Half star (optional, depending on your icon set)
                                            echo "<li><i class='bx bxs-star-half checked'></i></li>";
                                        } else {
                                            // Empty star
                                            echo "<li><i class='bx bx-star'></i></li>";
                                        }
                                    }
                                    ?>
                                </ul>
                                <span>(<?= $total_reviews ?>)</span>
                            </div>

                            <?php
                            if ($row1['stock_quantity'] < 1) {
                            ?>
                                <a href="#"><button class="add-to-cart">
                                        Out Of Stock
                                    </button></a><?php
                                                } else {
                                                    ?>
                                <a href="./php/add-to-cart.php?productId=<?php echo $row1['product_id'] ?>"><button class="add-to-cart">
                                        Add to cart
                                    </button></a>
                            <?php
                                                }
                            ?>
                        </div>
                    </div>
        <?php
                }
            }
        }
        ?>


        </div>
</div>

<div class="just-for-you">
    <div class="hero-heading">
        <div class="hero-top-heading">
            <div class="box"></div>
            <div class="text">Just for you</div>
        </div>
    </div>

    <div class="product-list">
        <?php
        $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="product-card" onclick="window.location.href='product-details.php?productId=<?php echo $row['product_id'] ?>'">
                <div class="product-image">
                    <img src="admin/uploads/<?php echo $row['main_image_url']; ?>" alt="">
                    <a href="php/add-wishlist.php?productId=<?php echo $row['product_id'] ?>"><i class='bx bx-heart'></i></a>
                </div>
                <div class="product-card-details">
                    <h1><?php echo $row['name'] ?></h1>

                    <div class="price">Rs. <?php echo $row['price'] ?></div>
                    <?php
                            $product_id = $row['product_id'];

                            $ratingQuery = "SELECT rating FROM reviews WHERE product_id = '$product_id'";
                            $ratingResult = mysqli_query($conn, $ratingQuery);

                            $ratings = [];
                            while ($ratingRow = mysqli_fetch_assoc($ratingResult)) {
                                $ratings[] = $ratingRow['rating'];
                            }

                            // Calculate total reviews and average rating
                            $total_reviews = count($ratings);
                            $average_rating = $total_reviews > 0 ? array_sum($ratings) / $total_reviews : 0;

                            // Round the average rating to the nearest half
                            $rounded_rating = round($average_rating * 2) / 2;
                            ?>
                            <div class="rating">
                                <ul>
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($rounded_rating >= $i) {
                                            // Full star
                                            echo "<li><i class='bx bxs-star checked'></i></li>";
                                        } elseif ($rounded_rating >= $i - 0.5) {
                                            // Half star (optional, depending on your icon set)
                                            echo "<li><i class='bx bxs-star-half checked'></i></li>";
                                        } else {
                                            // Empty star
                                            echo "<li><i class='bx bx-star'></i></li>";
                                        }
                                    }
                                    ?>
                                </ul>
                                <span>(<?= $total_reviews ?>)</span>
                            </div>
                    <?php
                    if ($row['stock_quantity'] < 1) {
                    ?>
                        <a href="#"><button class="add-to-cart">
                                Out Of Stock
                            </button></a><?php
                                        } else {
                                            ?>
                        <a href="./php/add-to-cart.php?productId=<?php echo $row['product_id'] ?>"><button class="add-to-cart">
                                Add to cart
                            </button></a>
                    <?php
                                        }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <button class="flash-view-all">See All</button>

</div>

<script>
    document.title = "Wishlist - " + document.title;
</script>

<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>