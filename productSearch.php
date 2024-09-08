<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");
if (!isset($_GET['searchTerm'])) {
    header("location: index.php");
}
$searchTerm = $_GET['searchTerm'];
?>

<div class="product-search">
    <div class="hero-heading">
        <div class="hero-top-heading">
            <div class="box"></div>
            <div class="text">Search Products</div>
        </div>
        <h1>Result of <?php echo $searchTerm ?></h1>
    </div>
    <div class="product-list">
    <?php
    $searchTerm1 = "%$searchTerm%"; // add wildcards for partial matching
    $sql = " SELECT p.*, c.category_name 
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.name LIKE '$searchTerm1' OR c.category_name LIKE '$searchTerm1'";

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
</div>


<script>
    document.title = "Search - <?php echo $searchTerm ?> - " + document.title;
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>