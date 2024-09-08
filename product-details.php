<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");


if (!isset($_GET['productId'])) {
    header("location:index.php");
    exit();
}
$productId = $_GET['productId'];
?>
<?php
$sql = "SELECT * FROM products WHERE product_id=" . $productId;
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>
<div class="product-view">
    <div class="all-info">
        <div class="images">
            <div class="small-images">
                <?php
                $smallImages = explode(',', $row['small_images']); // Split the string into an array
                $smallImages = array_reverse($smallImages);
                // Loop through the array and generate the image elements
                foreach ($smallImages as $image) {
                    echo '<img src="./admin/uploads/' . trim($image) . '" onclick="updateMainImage(this.src)" height="80" width="80" alt="">';
                }
                ?>
            </div>

            <div class="main-image">
                <img id="main-image" src="./admin/uploads/<?php echo $row['main_image_url'] ?>" width="400" height="450" alt="">
            </div>
        </div>
        <div class="view-details">
            <div class="product-view-details">
                <div class="heading"><?php echo $row['name'] ?></div>

                <div class="reviews">
                    <div class="stars">
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bxs-star'></i>
                        <i class='bx bx-star'></i>
                    </div>
                    <div class="total-reviews">(82)</div>
                </div>
                <div class="price">RS. <?php echo $row['price'] ?></div>
                <div class="short-description"><?php echo $row['short_description'] ?></div>
            </div>
            <div class="horizontal-line"></div>
            <div class="product-controls">
                <div class="purity flex">
                    <div class="title">Available Purity: </div>
                    <select name="" id="">
                        <option value="24K">24 K</option>
                    </select>
                </div>
                <div class="weight flex">
                    <div class="title">Available Weight: </div>

                    <select name="" id="">
                        <option value="<?php echo $row['weight'] ?>"><?php echo $row['weight'] ?> GM</option>
                    </select>
                </div>
                <div class="quantity-sec">
                    <div class="title">QTY.</div>
                    <div class="quantity">
                        <button class=" btn decreaseButton" onclick="changeQuantity(-1)">-</button>
                        <input id="quantity" type="number" value="1" onchange="quantity=this.value">
                        <button class=" btn increaseButton" onclick="changeQuantity(1)">+</button>
                    </div>
                </div>
                <script>
                    function addToCart(productId) {
                        var quantity = document.getElementById('quantity').value; // Get the quantity value from the input field
                        if (quantity <= 0) {
                            alert("Please select a valid quantity."); // Optional: Alert if quantity is not valid
                            return;
                        }
                        window.location.href = 'php/add-to-cart.php?productId=' + productId + '&quantity=' + quantity; // Redirect with productId and quantity
                    }
                </script>

                <div class="all-buttons">
                    <?php
                    if ($row['stock_quantity'] < 1) {
                    ?>
                        <a href="#"><button class="add-to-cart">
                                Out Of Stock
                            </button></a><?php
                                        } else {
                                            ?>
                        <a onclick="addToCart(<?php echo $row['product_id']; ?>)"><button class="add-to-cart">
                                Add to cart
                            </button></a>
                    <?php
                                        }
                    ?>
                   

                    <!-- <button class="btn normal" class="add-to-cart">Buy Now</button> -->
                    <button class="btn small-button" class="wishlists" onclick="window.location.href='php/add-wishlist.php?productId=<?php echo $row['product_id'] ?>'"><i class='bx bx-heart'></i></button>
                    <button class="btn small-button share" onclick="shareProduct('<?php echo $row['name']; ?>', '<?php echo $row['product_id']; ?>')">
                        <i class='bx bx-share-alt'></i>
                    </button>
                    <script>
                        function shareProduct(productName, productId) {
                            const productUrl = window.location.origin + '/product-details.php?productId=' + productId; // Construct the product URL
                            const shareText = 'Check out this product: ' + productName + ' - ' + productUrl; // Text to share

                            // Check if the Web Share API is supported
                            if (navigator.share) {
                                navigator.share({
                                        title: productName,
                                        text: shareText,
                                        url: productUrl
                                    })
                                    .then(() => console.log('Share successful'))
                                    .catch((error) => console.error('Error sharing:', error));
                            } else {
                                // Fallback for browsers that do not support the Web Share API
                                alert('Share this link: ' + productUrl);
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="product-description">
        <div class="heading">Product Details</div>
        <div class="description">
            <?php echo $row['long_description'] ?>
        </div>
    </div>


</div>
<div class="recommendation">
    <div class="hero-heading">
        <div class="hero-top-heading">
            <div class="box"></div>
            <div class="text">Related Items</div>
        </div>
    </div>
    <div class="product-list">
        <?php
        $sqloo = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
        $resultoo = mysqli_query($conn, $sqloo);
        while ($rowo = mysqli_fetch_assoc($resultoo)) {
        ?>
            <div class="product-card" onclick="window.location.href='product-details.php?productId=<?php echo $rowo['product_id'] ?>'">
                <div class="product-image">
                    <img src="admin/uploads/<?php echo $rowo['main_image_url']; ?>" alt="">
                    <a href="php/add-wishlist.php?productId=<?php echo $rowo['product_id'] ?>"><i class='bx bx-heart'></i></a>
                </div>
                <div class="product-card-details">
                    <h1><?php echo $rowo['name'] ?></h1>

                    <div class="price">Rs. <?php echo $rowo['price'] ?></div>
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
                    <?php
                    if ($rowo['stock_quantity'] < 1) {
                    ?>
                        <a href="#"><button class="add-to-cart">
                                Out Of Stock
                            </button></a><?php
                                        } else {
                                            ?>
                        <a href="./php/add-to-cart.php?productId=<?php echo $rowo['product_id'] ?>"><button class="add-to-cart">
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

</div>

<script>
    document.title = "<?php echo $row['name'] ?> - " + document.title;
</script>
<script src="./js/product-details.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>