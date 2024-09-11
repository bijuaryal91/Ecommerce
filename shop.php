<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");

// Check if 'category' parameter exists in the URL
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

// Base SQL query
$sql = "SELECT * FROM products";

// If a category filter is set, modify the SQL query to use LIKE
if ($categoryFilter) {
    $sql .= " INNER JOIN categories ON products.category_id = categories.category_id WHERE categories.category_name LIKE '%" . mysqli_real_escape_string($conn, $categoryFilter) . "%'";
}

$result = mysqli_query($conn, $sql);
?>

<div class="shop-page">
    <div class="hero-heading">
        <div class="">
            <div class="hero-top-heading">
                <div class="box"></div>
                <div class="text">Shop Page</div>
            </div>
            <h1>All Products</h1>
        </div>
        <div class="search-shop">
            <input id="searchProduct" type="text" placeholder="Search Product">
        </div>
    </div>

    <div class="main-shop">
        <div class="filter-side">
            <div class="filter-category">
                <h3>Categories</h3>
                <ul>
                    <li><input type="checkbox" class="category" value="Gold"> Gold</li>
                    <li><input type="checkbox" class="category" value="Necklaces"> Necklaces</li>
                    <li><input type="checkbox" class="category" value="Ring"> Rings</li>
                    <li><input type="checkbox" class="category" value="Earrings"> Earrings</li>
                </ul>
            </div>
            <div class="filter-price">
                <h3>Price Range</h3>
                <input type="range" id="priceRange" min="0" max="500000" step="500" value="500000">
                <p>Max Price: Rs. <span id="priceValue">500000</span></p>
            </div>
            <div class="filter-rating">
                <h3>Rating</h3>
                <ul>
                    <li><input type="radio" name="rating" class="rating-filter" value="5"> 5 stars</li>
                    <li><input type="radio" name="rating" class="rating-filter" value="4"> 4 stars & up</li>
                    <li><input type="radio" name="rating" class="rating-filter" value="3"> 3 stars & up</li>
                    <li><input type="radio" name="rating" class="rating-filter" value="2"> 2 stars & up</li>
                    <li><input type="radio" name="rating" class="rating-filter" value=""> All</li>
                </ul>
            </div>
        </div>

        <div class="product-side">
            <div class="product-list">
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    $sqlC = "SELECT * FROM categories WHERE category_id=" . $row['category_id'];
                    $rowC = mysqli_fetch_assoc(mysqli_query($conn, $sqlC));
                ?>
                    <div class="product-card" onclick="window.location.href='product-details.php?productId=<?php echo $row['product_id'] ?>'" data-category="<?php echo $rowC['category_name'] ?>">
                        <div class="product-image">
                            <img src="admin/uploads/<?php echo $row['main_image_url']; ?>" alt="">
                            <a href="php/add-wishlist.php?productId=<?php echo $row['product_id'] ?>"><i class='bx bx-heart'></i></a>
                        </div>
                        <div class="product-card-details">
                            <h1><?php echo $row['name']; ?></h1>
                            <div class="price">Rs. <?php echo $row['price']; ?></div>
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
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('searchProduct');
        const productCards = document.querySelectorAll('.product-card');
        const priceRange = document.getElementById('priceRange');
        const priceValue = document.getElementById('priceValue');
        const categoryFilters = document.querySelectorAll('.category');
        const ratingFilters = document.querySelectorAll('.rating-filter');

        // Function to filter products based on search input
        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategories = Array.from(categoryFilters).filter(cat => cat.checked).map(cat => cat.value);
            const selectedRating = document.querySelector('.rating-filter:checked') ? document.querySelector('.rating-filter:checked').value : null;
            const maxPrice = parseInt(priceRange.value);

            productCards.forEach(card => {
                const productName = card.querySelector('h1').innerText.toLowerCase();
                const productCategory = card.dataset.category;
                const productPrice = parseInt(card.querySelector('.price').innerText.replace('Rs. ', ''));
                const productRating = card.querySelectorAll('.checked').length;

                let showProduct = true;

                // Search filter
                if (!productName.includes(searchTerm)) {
                    showProduct = false;
                }

                // Category filter
                if (selectedCategories.length > 0 && !selectedCategories.includes(productCategory)) {
                    showProduct = false;
                }

                // Price filter
                if (productPrice > maxPrice) {
                    showProduct = false;
                }

                // Rating filter
                if (selectedRating && productRating < selectedRating) {
                    showProduct = false;
                }

                // Show/Hide product
                if (showProduct) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Event listeners for search and filters
        searchInput.addEventListener('input', filterProducts);
        priceRange.addEventListener('input', () => {
            priceValue.innerText = priceRange.value;
            filterProducts();
        });
        categoryFilters.forEach(filter => filter.addEventListener('change', filterProducts));
        ratingFilters.forEach(filter => filter.addEventListener('change', filterProducts));
    });
</script>
<script>
    document.title = "Shops - " + document.title;
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>