<?php
ob_start(); // Start output buffering
include_once("./includes/header.php"); // Include header
include_once("./includes/navbar.php"); // Include navigation bar
include_once("./includes/connect.php"); // Include database connection

// Check if 'searchTerm' is set in the URL, redirect to index if not
if (!isset($_GET['searchTerm'])) {
  header("location: index.php");
}

// Get the search term from the URL
$searchTerm = $_GET['searchTerm'];
?>

<div class="product-search">
  <div class="hero-heading">
    <div class="hero-top-heading">
      <div class="box"></div>
      <div class="text">Search Products</div>
    </div>
    <h1>Result of <?php echo htmlspecialchars($searchTerm); ?></h1>
  </div>
  <div class="product-list">
    <?php
    // Sanitize the search term to prevent SQL injection
    $searchTerm1 = mysqli_real_escape_string($conn, $searchTerm);

    // SQL query to fetch products and categories that match the search term
    $sql = "SELECT p.*, c.category_name 
                FROM products p
                JOIN categories c ON p.category_id = c.category_id
                WHERE MATCH(p.name) AGAINST('$searchTerm1' IN NATURAL LANGUAGE MODE)
                OR MATCH(c.category_name) AGAINST('$searchTerm1' IN NATURAL LANGUAGE MODE)";

    // Execute the query and get the result
    $result = mysqli_query($conn, $sql);

    // Initialize an array to store the fetched products
    $products = [];
    // Loop through the results and store each row in the $products array
    while ($row = mysqli_fetch_assoc($result)) {
      $products[] = $row;
    }

    // Sort the products array by product name
    usort($products, function ($a, $b) {
      return strcmp($a['name'], $b['name']); // Compare product names for sorting
    });

    // Binary search function to find products by name (partial match)
    function binarySearchPartial($array, $searchTerm)
    {
      $results = []; // Array to hold matching products
      foreach ($array as $product) {
        if (stripos($product['name'], $searchTerm) !== false) {
          // If found, add to results
          $results[] = $product;
        }
      }
      return $results; // Return an array of matching products
    }

    // Perform binary search on the sorted products array
    $matchingProducts = binarySearchPartial($products, $searchTerm);

    // Check if matching products are found
    if (!empty($matchingProducts)) {
      foreach ($matchingProducts as $row) {
    ?>
        <div class="product-card" onclick="window.location.href='product-details.php?productId=<?php echo $row['product_id'] ?>'">
          <div class="product-image">
            <img src="admin/uploads/<?php echo htmlspecialchars($row['main_image_url']); ?>" alt="">
            <a href="php/add-wishlist.php?productId=<?php echo $row['product_id'] ?>"><i class='bx bx-heart'></i></a>
          </div>
          <div class="product-card-details">
            <h1><?php echo htmlspecialchars($row['name']); ?></h1>
            <div class="price">Rs. <?php echo number_format($row['price'], 2); ?></div>
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
    } else {
      // If no product is found, display a message
      echo "<p>No products found matching your search.</p>";
    }
    ?>
  </div>
</div>

<script>
  // Set the page title dynamically based on the search term
  document.title = "Search - <?php echo htmlspecialchars($searchTerm); ?> - " + document.title;
</script>
<?php
include_once('./includes/footer-menu.php'); // Include footer menu
include_once('./includes/footer.php'); // Include footer
?>