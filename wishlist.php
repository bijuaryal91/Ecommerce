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
                            <div class="rating">
                                <ul>
                                    <li><i class='bx bxs-star checked'></i></li>
                                    <li><i class='bx bxs-star checked'></i></li>
                                    <li><i class='bx bxs-star checked'></i></li>
                                    <li><i class='bx bxs-star checked'></i></li>
                                    <li><i class='bx bx-star'></i></li>
                                </ul>
                                <span>(88)</span>
                            </div>
                            <a href="./php/add-to-cart.php?productId=<?php echo $row['product_id'] ?>"><button class="add-to-cart">
                                    Add to cart
                                </button></a>
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
                    <div class="rating">
                        <ul>
                            <li><i class='bx bxs-star checked'></i></li>
                            <li><i class='bx bxs-star checked'></i></li>
                            <li><i class='bx bxs-star checked'></i></li>
                            <li><i class='bx bxs-star checked'></i></li>
                            <li><i class='bx bx-star'></i></li>
                        </ul>
                        <span>(88)</span>
                    </div>
                    <a href="./php/add-to-cart.php?productId=<?php echo $row['product_id'] ?>"><button class="add-to-cart">
                            Add to cart
                        </button></a>
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