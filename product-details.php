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
                <div class="reviews">
                    <div class="stars">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            if ($rounded_rating >= $i) {
                                // Full star
                                echo "<i class='bx bxs-star'></i>";
                            } elseif ($rounded_rating >= $i - 0.5) {
                                // Half star
                                echo "<i class='bx bxs-star-half'></i>";
                            } else {
                                // Empty star
                                echo "<i class='bx bx-star'></i>";
                            }
                        }
                        ?>
                    </div>
                    <div class="total-reviews">(<?= $total_reviews ?>)</div>
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
                        <input id="quantity" type="number" value="1" onchange="quantity=this.value" disabled>
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
<div class="product-reviews">
    <?php
    $sql = "SELECT * FROM reviews WHERE product_id=" . $row['product_id'];
    $reviewResult = mysqli_query($conn, $sql);
    ?>
    <div class="review-heading">Reviews</div>
    <div class="review-details">
        <div class="reviews">

            <?php
            if (mysqli_num_rows($reviewResult) > 0) {
                while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                    $userDetails = $reviewRow['user_id'];
                    $userSql = "SELECT * FROM users WHERE user_id='$userDetails'";
                    $userRow = mysqli_fetch_assoc(mysqli_query($conn, $userSql));
                    $reviewDate = new DateTime($reviewRow['created_at']);
                    $today = new DateTime();
                    $interval = $today->diff($reviewDate);
            ?>
                    <div class="comment-part">
                        <div class="user-img-part">
                            <div class="user-img">
                                <img src="./users/<?php echo $userRow['profile_pic'] ?>">
                            </div>
                            <div class="user-text">
                                <h4><?php echo $interval->days ?> days ago</h4>
                                <p><?php echo $userRow['first_name'] . ' ' . $userRow['last_name'] ?></p>

                            </div>
                            <div style="clear: both;"></div>
                        </div>
                        <div class="comment">
                            <div class="comment-ratings">
                                <?php
                                $maxStars = 5; // Maximum number of stars
                                $i = $reviewRow['rating']; // Rating value

                                // Loop for full stars
                                for ($j = 1; $j <= $i; $j++) {
                                ?>
                                    <i aria-hidden="true" class="bx bxs-star"></i> <!-- Full star icon -->
                                <?php
                                }

                                // Loop for empty stars
                                for ($j = $i + 1; $j <= $maxStars; $j++) {
                                ?>
                                    <i aria-hidden="true" class="bx bx-star"></i> <!-- Empty star icon -->
                                <?php
                                }
                                ?>


                            </div>
                            <p><?php echo $reviewRow['comment'] ?></p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="comment-part">
                    No reviews available for this product
                </div>
            <?php
            }
            ?>

        </div>
    </div>
</div>

<div class="review-wrapper">
    <h3>Write a review</h3>
    <form action="./php/submit-review.php" method="post">
        <div class="stars-container">
            <input type="number" name="rating" hidden>
            <input type="hidden" name="uid" value="<?php echo $_SESSION['user_id'] ?>">
            <input type="hidden" name="pid" value="<?php echo $_GET['productId'] ?>">
            <i class='bx bx-star single-star' style="--i: 0;"></i>
            <i class='bx bx-star single-star' style="--i: 1;"></i>
            <i class='bx bx-star single-star' style="--i: 2;"></i>
            <i class='bx bx-star single-star' style="--i: 3;"></i>
            <i class='bx bx-star single-star' style="--i: 4;"></i>
        </div>
        <textarea class="opinion" name="opinion" cols="30" rows="5" placeholder="Your opinion..."></textarea>
        <div class="error-message hidden    " style="text-align: left;">h</div>
        <div class="button-group">
            <?php
            if (isset($_SESSION['user_status'])) {
            ?>
                <button type="submit" class="btn submit-btn" name="submit">Submit</button>
                <button class="btn cancel-btn">Cancel</button>
            <?php
            } else {
            ?>
                Please log in to post your review.
            <?php
            }
            $sqlU = "SELECT * FROM users WHERE user_id =" . $_SESSION['user_id'];
            $sqlR = mysqli_fetch_assoc(mysqli_query($conn, $sqlU));
            ?>
        </div>
        <p style="text-align: left;margin-top: 10px;">Commenting as <span style="color: var(--primary-color);"><?php echo $sqlR['first_name'] . ' ' . $sqlR['last_name'] ?></span></p>
    </form>
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
                    <?php
                    $product_id = $rowo['product_id'];

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

<script>
    const allStars = document.querySelectorAll('.stars-container .single-star');
    const ratingInput = document.querySelector('.stars-container input');
    const form = document.querySelector('form');
    const cancelButton = document.querySelector('.cancel-btn');

    // Handle star rating selection
    allStars.forEach((item, idx) => {
        item.addEventListener('click', function() {
            let click = 0;
            ratingInput.value = idx + 1;

            allStars.forEach(i => {
                i.classList.replace('bxs-star', 'bx-star');
                i.classList.remove('active-star');
            });
            for (let i = 0; i < allStars.length; i++) {
                if (i <= idx) {
                    allStars[i].classList.replace('bx-star', 'bxs-star');
                    allStars[i].classList.add('active-star');
                } else {
                    allStars[i].style.setProperty('--i', click);
                    click++;
                }
            }
        });
    });

    // Handle form reset with Cancel button
    cancelButton.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default button behavior

        // Reset form fields
        form.reset();

        // Reset star ratings
        allStars.forEach(star => {
            star.classList.replace('bxs-star', 'bx-star'); // Reset star style
            star.classList.remove('active-star'); // Remove active class from stars
        });
        ratingInput.value = ''; // Reset hidden input value
    });
    form.addEventListener('submit', (event) => {
        // event.preventDefault();
        const error = document.querySelector('.error-message');
        const opinionInput = document.querySelector('.opinion');
        let isValid = true;

        // Clear any existing error messages
        error.classList.add("hidden");

        // Check if a rating has been selected
        if (!ratingInput.value) {
            error.innerHTML = "Please select a star rating";
            error.classList.remove("hidden");
            isValid = false;
        }

        // Check if the opinion is provided
        if (opinionInput.value.trim() === '') {
            error.innerHTML = "Please provide your opinion.";
            error.classList.remove("hidden");
            isValid = false;
        }

        console.log(isValid);
        // If any validation fails, prevent form submission
        if (!isValid) {
            event.preventDefault();
            return false;
        }
    });
</script>