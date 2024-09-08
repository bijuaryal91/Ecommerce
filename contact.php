<?php
include_once("./includes/header.php");
include_once("./includes/navbar.php");
?>

<div class="contact-us">
    <div class="heading">Contact Us</div>
    <div class="contact-details">
        <div class="contact-info">
            <div class="call">
                <div class="heading1">
                    <i class='bx bx-phone'></i>
                    <h2>Call To Us</h2>
                </div>
                <div class="call-description">
                    <p>We are available 24/7</p>
                    <p>Phone: 9811111112</p>
                </div>
            </div>
            <div class="horizontal-line"></div>
            <div class="write">
                <div class="heading1">
                    <i class='bx bx-envelope'></i>
                    <h2>Write To Us</h2>
                </div>
                <div class="write-description">
                    <p>Fill out our form and we will contact you withing 24 hours.</p>
                    <p>Email: contact@rkstores.com</p>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <form method="post">
                <div class="personal-details">
                    <input type="text" name="name" placeholder="Your Name *" id="name">
                    <input type="text" name="email" placeholder="Your Email *" id="email">
                    <input type="text" name="phone" placeholder="Your Phone *" id="phone">
                </div>
                <div class="message">
                    <textarea name="message" placeholder="Your Message" id="message"></textarea>
                </div>
                <div class="sent-message">
                    <div class="error-message hidden">This is an error</div>
                    <button class="btn send-contact">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="./js/contactUsValidation.js"></script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>