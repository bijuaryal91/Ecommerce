<?php
include_once("./includes/header.php");
include_once("./includes/navbar.php");
?>

<div class="product-view">
    <div class="all-info">
        <div class="images">
            <div class="small-images">
                <img src="./products/1.jpeg" onclick="updateMainImage(this.src)" height="80" width="80" alt="">
                <img src="./products/2.jpeg" onclick="updateMainImage(this.src)" height="80" width="80" alt="">
                <img src="./products/3.jpg" onclick="updateMainImage(this.src)" height="80" width="80" alt="">
                <img src="./products/4.jpg" onclick="updateMainImage(this.src)" height="80" width="80" alt="">
            </div>
            <div class="main-image">
                <img id="main-image" src="./products/2.jpeg" width="400" height="450" alt="">
            </div>
        </div>
        <div class="view-details">
            <div class="product-view-details">
                <div class="heading">Havic HV G-92 Gamepad</div>
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
                <div class="price">RS. 6500</div>
                <div class="short-description">PlayStation 5 Controller Skin High quality vinyl with air channel adhesive for easy bubble free install & mess free removal Pressure sensitive.</div>
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
                        <option value="12GM">12 GM</option>
                    </select>
                </div>
                <div class="quantity-sec">
                    <div class="title">QTY.</div>
                    <div class="quantity">
                        <button class=" btn decreaseButton" onclick="changeQuantity(-1)">-</button>
                        <input id="quantity" type="number" value="1">
                        <button class=" btn increaseButton" onclick="changeQuantity(1)">+</button>
                    </div>
                </div>
                <div class="all-buttons">
                    <button class="btn normal" class="add-to-cart">Add to Cart</button>
                    <button class="btn normal" class="add-to-cart">Buy Now</button>
                    <button class="btn small-button" class="wishlists"><i class='bx bx-heart'></i></button>
                    <button class="btn small-button" class="share"><i class='bx bx-share-alt'></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="product-description">
        <div class="heading">Product Details</div>
        <div class="description">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas exercitationem ea molestias facere officia quisquam, fugiat nam autem iusto aliquid dolor quod explicabo minima, a ex culpa laborum est! Nobis magnam similique expedita mollitia? Veniam iure excepturi reprehenderit iste perspiciatis possimus mollitia perferendis tempora obcaecati laudantium dignissimos, atque rem modi officia, minima suscipit aliquam odit! Fuga corrupti obcaecati quibusdam nostrum repudiandae provident iure ea earum blanditiis nobis facere eius harum necessitatibus numquam explicabo in ratione, aliquid iusto atque! Facilis qui pariatur enim fuga possimus excepturi iste earum incidunt ipsa illo. Dolorum nesciunt, sequi culpa eligendi dolores temporibus expedita facere quisquam!

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
        <div class="product-card">
            <div class="product-image">
                <img src="products/5.jpg" alt="">
                <i class='bx bx-heart'></i>
            </div>
            <div class="product-card-details">
                <h1>Women Bag</h1>
                <p>Lorem ipsum dolor sit amet.</p>
                <div class="price">120$</div>
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
                <button class="add-to-cart">
                    Add to cart
                </button>
            </div>
        </div>
        <div class="product-card">
            <div class="product-image">
                <img src="products/5.jpg" alt="">
                <i class='bx bx-heart'></i>
            </div>
            <div class="product-card-details">
                <h1>Women Bag</h1>
                <p>Lorem ipsum dolor sit amet.</p>
                <div class="price">120$</div>
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
                <button class="add-to-cart">
                    Add to cart
                </button>
            </div>
        </div>
        <div class="product-card">
            <div class="product-image">
                <img src="products/5.jpg" alt="">
                <i class='bx bx-heart'></i>
            </div>
            <div class="product-card-details">
                <h1>Women Bag</h1>
                <p>Lorem ipsum dolor sit amet.</p>
                <div class="price">120$</div>
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
                <button class="add-to-cart">
                    Add to cart
                </button>
            </div>
        </div>
        <div class="product-card">
            <div class="product-image">
                <img src="products/5.jpg" alt="">
                <i class='bx bx-heart'></i>
            </div>
            <div class="product-card-details">
                <h1>Women Bag</h1>
                <p>Lorem ipsum dolor sit amet.</p>
                <div class="price">120$</div>
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
                <button class="add-to-cart">
                    Add to cart
                </button>
            </div>
        </div>
    </div>

</div>
<script>
    document.title = "Products - " + document.title;
</script>
<script src="./js/product-details.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>