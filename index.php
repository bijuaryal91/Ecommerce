<?php
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");
// session_destroy();
?>
<div class="slideshow-container">
  <div class="mySlides fade">
    <img src="banners/16774.jpg" style="width: 100%" />
  </div>

  <div class="mySlides fade">
    <img src="banners/16774.jpg" style="width: 100%" />
  </div>

  <div class="mySlides fade">
    <img src="banners/2672891.jpg" style="width: 100%" />
  </div>

  <div class="mySlides fade">
    <img
      src="banners/bannerImage1b20cb2acb8a275c9e647a3555e8.png"
      style="width: 100%" />
  </div>

  <a class="prev" id="prev">&#10094;</a>
  <a class="next" id="next">&#10095;</a>
  <div class="clear"></div>
</div>


<div class="flash-sale">
  <div class="hero-heading">
    <div class="hero-top-heading">
      <div class="box"></div>
      <div class="text">Today's</div>
    </div>
    <h1>Flash Sales</h1>
  </div>
  <div class="flash-card">
    <div class="wrapper">
      <i class='bx bx-chevron-left indicators' id="left"></i>
      <ul class="carousel">
        <?php
        $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 10";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
          <li class="product" onclick="window.location.href='product-details.php?productId=<?php echo $row['product_id'] ?>'">
            <div class="product-image">
              <img src="admin/uploads/<?php echo $row['main_image_url']; ?>" alt="">
              <a href="php/add-wishlist.php?productId=<?php echo $row['product_id'] ?>"><i class='bx bx-heart'></i></a>
            </div>
            <div class="product-details">
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
          </li>
        <?php
        }
        ?>

      </ul>
      <i class='bx bx-chevron-right indicators'></i>
    </div>
  </div>
  <button class="flash-view-all" onclick="window.location.href='shop.php'">View All Products</button>
  <div class="horizontal-line"></div>
  <div class="category-section">
    <div class="hero-heading">
      <div class="hero-top-heading">
        <div class="box"></div>
        <div class="text">Categories</div>
      </div>
      <h1>Browse By Category</h1>
    </div>
  </div>
  <div class="categories">
    <ul>
      <a href="shop.php?category=armlet">
        <li>
          <img src="ornaments/armlet.png" alt="">
          <span>Armlet</span>
        </li>
      </a>
      <a href="shop.php?category=bangle">
        <li>
          <img src="ornaments/bangle.png" alt="">
          <span>Bangle</span>
        </li>
      </a>
      <a href="shop.php?category=bracelet">
        <li>
          <img src="ornaments/bracelet.png" alt="">
          <span>Bracelet</span>
        </li>
      </a>
      <a href="shop.php?category=pendant">
        <li>
          <img src="ornaments/pendant.png" alt="">
          <span>Pendant</span>
        </li>
      </a>
      <a href="shop.php?category=necklace">
        <li>
          <img src="ornaments/necklace.png" alt="">
          <span>Necklace</span>
        </li>
      </a>
      <a href="shop.php?category=locket">
        <li>
          <img src="ornaments/locket.png" alt="">
          <span>Locket</span>
        </li>
      </a>
    </ul>
  </div>
  <div class="horizontal-line"></div>
</div>

<div class="best-selling">
  <div class="hero-heading">
    <div class="hero-top-heading">
      <div class="box"></div>
      <div class="text">This Month</div>
    </div>
    <h1>Best Selling Product</h1>
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
  <button class="flash-view-all best-sell" onclick="window.location.href='shop.php'">View All</button>
</div>


<div class="exclusive-banner">
  <a href="#">
    <img src="./banners/buynow.png" alt="">
  </a>
</div>
<div class="best-selling">
  <div class="hero-heading">
    <div class="hero-top-heading">
      <div class="box"></div>
      <div class="text">Our Products</div>
    </div>
    <h1>Explore Our Products</h1>
  </div>
  <div class="product-list">
    <?php
    $sql = "SELECT * FROM products ORDER BY RAND() LIMIT 8";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
      <div class="product-card" onclick="window.location.href='product-details.php?productId=<?php echo $row['product_id'] ?>'">
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
  <button class="flash-view-all best-sell" onclick="window.location.href='shop.php'">View All</button>
  <div class="horizontal-line"></div>
</div>

<div class="services">
  <div class="fast-delivery service-card">
    <div class="icon">
      <i class='bx bx-package'></i>
    </div>
    <div class="services-heading">
      <h1>free and fast delivery</h1>
      <p>Free delivery for all orders</p>
    </div>
  </div>
  <div class="customer-service service-card">
    <div class="icon">
      <i class='bx bx-headphone'></i>
    </div>
    <div class="services-heading">
      <h1>24/7 customer service</h1>
      <p>Friendly 24/7 customer support</p>
    </div>
  </div>
  <div class="money-back service-card">
    <div class="icon">
      <i class='bx bx-lock-alt'></i>
    </div>
    <div class="services-heading">
      <h1>money back guarantee</h1>
      <p>We return money within 7 days</p>
    </div>
  </div>
</div>



<script src="./js/imageslider.js"></script>
<script src="./js/flashsalecard.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>