<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");


if (!isset($_SESSION['user_status'])) {
    header("location:login.php");
    exit();
}
$user_id = $_SESSION['user_id'];
// session_destroy();

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
if (mysqli_num_rows($items_result) > 0) {
    while ($row = mysqli_fetch_assoc($items_result)) {
        $product_total = $row['price'] * $row['quantity'];
        $total_cost += $product_total;
    }
}
?>

<div class="my-cart">
    <form action="./php/update-cart.php" method="post">
        <div class="cart-list">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <?php
                if (mysqli_num_rows($items_result) > 0) {
                    mysqli_data_seek($items_result, 0); // Reset result pointer
                    while ($row = mysqli_fetch_assoc($items_result)) {
                        $product_total = $row['price'] * $row['quantity'];
                ?>
                    <tr>
                        <td data-label="Product" class="cart-image">
                            <img src="./admin/uploads/<?php echo $row['main_image_url'] ?>" alt="">
                            <p><?php echo $row['name'] ?></p>
                        </td>
                        <td data-label="Price">Rs. <?php echo $row['price'] ?></td>
                        <td data-label="Quantity">
                            <input type="number" name="quantity[<?php echo $row['product_id']; ?>]" value="<?php echo $row['quantity'] ?>">
                        </td>
                        <td data-label="Subtotal">Rs. <?php echo $product_total ?></td>
                        <td data-label="Action">
                            <button type="button" onclick="removeItem(<?php echo $row['product_id'] ?>)" class="btn">Remove</button>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="5">No Items In The Cart</td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <div class="action-buttons">
                <a href="shop.php"><button type="button" class="cart-action-button">Return To Shop</button></a>
                <button type="submit" class="cart-action-button">Update Cart</button>
            </div>
        </div>
    </form>
    <div class="further-cart-info">
        <form action="./php/update-cart.php" method="post">
            <div class="coupen-code hidden">
                <input type="text" name="coupon_code" placeholder="Coupon Code">
                <button type="submit" name="redeem_coupon" class="btn">Redeem</button>
            </div>
        </form>
        <div class="cart-total">
            <div class="total-heading">Cart Total</div>
            <div class="subtotal">
                <p>Subtotal: </p>
                <p id="subtotal-amount">RS. <?php echo $total_cost; ?></p>
            </div>
            <div class="horizontal-line"></div>
            <div class="subtotal">
                <p>Shipping: </p>
                <p>Free</p>
            </div>
            <div class="horizontal-line"></div>
            <div class="subtotal">
                <p>Total: </p>
                <p id="total-amount" class="total-amount">RS. <?php echo $total_cost; ?></p>
            </div>
            <button class="btn btn-fluid">Proceed</button>
        </div>
    </div>
</div>

<script>
    function removeItem(productId) {
        if (confirm("Are you sure you want to remove this item?")) {
            window.location.href = `./php/delete_from_cart.php?product_id=${productId}`;
        }
    }
    document.title = "My Cart - " + document.title;
</script>
<script src="./js/cartCalculation.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>
