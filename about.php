<?php
include_once("./includes/header.php");
include_once("./includes/navbar.php");
?>

<div class="our-story">
    <div class="story-info">
        <div class="heading">Our Story</div>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates maiores nam dicta repudiandae quisquam. Vitae perferendis, perspiciatis facere aliquam dolorem architecto in nisi natus mollitia nam omnis asperiores eaque nihil minima labore culpa. Pariatur, ut aperiam. Voluptates harum animi provident?</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit ullam beatae harum placeat itaque fugit natus accusamus aliquam vel. Aspernatur?</p>
        <div class="sub-heading">Our Legacy</div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique quam commodi eos cum fugiat. Magnam obcaecati magni hic facilis repellendus?</p>
        <div class="sub-heading">What We Do?</div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique quam commodi eos cum fugiat. Magnam obcaecati magni hic facilis repellendus?</p>
        <div class="sub-heading">Our Collection</div>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique quam commodi eos cum fugiat. Magnam obcaecati magni hic facilis repellendus?</p>
       
    </div>
    <div class="banner">
        <img src="./banners/about.webp" alt="">
    </div>
</div>

<div class="services our-records">
    <div class="fast-delivery service-card">
        <div class="icon">
        <i class='bx bx-building-house' ></i>
        </div>
        <div class="services-heading">
            <h1>10.5K</h1>
            <p>Items In Our Site</p>
        </div>
    </div>
    <div class="customer-service service-card">
        <div class="icon">
        <i class='bx bx-dollar-circle' ></i>
        </div>
        <div class="services-heading">
            <h1>33K</h1>
            <p>Monthly Product Sale</p>
        </div>
    </div>
    <div class="money-back service-card">
        <div class="icon">
        <i class='bx bx-shopping-bag' ></i>
        </div>
        <div class="services-heading">
            <h1>45.5K</h1>
            <p>Customer Active In Our Site</p>
        </div>
    </div>
    <div class="money-back service-card">
        <div class="icon">
        <i class='bx bx-wallet' ></i>
        </div>
        <div class="services-heading">
            <h1>250M</h1>
            <p>Annual Gross Sale</p>
        </div>
    </div>
</div>

<div class="team-member">
    <div class="container">
        <i id="prev" class="fa-solid fa-angle-left"></i>
        <ul class="slider">
            <li class="slide">
                <div class="image"><img src="users/john-doe.jpg" alt="img" draggable="false"></div>
                <h2>John Doe</h2>
                <span>Founder</span>
            </li>
            <li class="slide">
                <div class="image"><img src="users/john-doe.jpg" alt="img" draggable="false"></div>
                <h2>John Doe</h2>
                <span>Co-founder</span>
            </li>
            <li class="slide">
                <div class="image"><img src="users/john-doe.jpg" alt="img" draggable="false"></div>
                <h2>John Doe</h2>
                <span>Sales Person</span>
            </li>
            <li class="slide">
                <div class="image"><img src="users/john-doe.jpg" alt="img" draggable="false"></div>
                <h2>John Doe</h2>
                <span>Marketing Head</span>
            </li>
            <li class="slide">
                <div class="image"><img src="users/john-doe.jpg" alt="img" draggable="false"></div>
                <h2>John Doe</h2>
                <span>Accountant</span>
            </li>
            <li class="slide">
                <div class="image"><img src="users/john-doe.jpg" alt="img" draggable="false"></div>
                <h2>John Doe</h2>
                <span>Socia Media Handler</span>
            </li>
        </ul>
        <i id="next" class="fa-solid fa-angle-right"></i>
    </div>
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


<script>
    document.title = "About Us - " + document.title;
</script>
<script src="./js/aboutUsSlider.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>