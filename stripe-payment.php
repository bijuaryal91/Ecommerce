<?php 
    ob_start();
    session_start();
    require_once './includes/connect.php';
    if(!isset($_SESSION['user_status']) || empty($_SESSION['user_status'])){
        header('location: login.php');
        exit();
    }
    if(!isset($_SESSION['orderId']) || empty($_SESSION['orderId'])){
        header('location: index.php');
        exit();
    }
    $total_amount = $_SESSION['amount'];
    $orderId = $_SESSION['orderId'];
    $paymentMethod = $_SESSION['paymentM'];
    $email = $_SESSION['emailO'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay</title>
    <link rel="stylesheet" href="./css/stripeStyle.css">
</head>
<body>
    <form action="php/stripe-payment.php" method="post">
        <input type="hidden" name="stripeToken" id="stripeToken">
        <label>
            <input name="cardholder-name" class="field is-empty" placeholder="Jane Doe" required="required" />
            <span><span>Card Holder Name</span></span>
        </label>
        <label>
            <input name="phone" class="field is-empty" type="tel" placeholder="(123) 456-7890" />
            <span><span>Phone number</span></span>
        </label>
        <label>
            <div id="card-element" class="field is-empty"></div>
            <span><span>Credit or debit card</span></span>
        </label>
        <button type="submit">Pay Rs. <?php echo $total_amount; ?></button>
        <div class="outcome">
            <div class="error" role="alert"></div>
        </div>
    </form>
</body>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('pk_test_51PvxcyGWPrZNMW0vgCWBjPvtUaIzJkHkLCzcsSYVuDSyjapCCgzGLL8BEBcjVyTSnhV9xRKyVBzoU6usIcoQuCkP00kNCQSGOK');
    var elements = stripe.elements();
    var card = elements.create('card', {
        iconStyle: 'solid',
        style: {
            base: {
                iconColor: '#8898AA',
                color: 'white',
                lineHeight: '36px',
                fontWeight: 300,
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSize: '19px',
                '::placeholder': {
                    color: '#8898AA',
                },
            },
            invalid: {
                iconColor: '#e85746',
                color: '#e85746',
            }
        },
        classes: {
            focus: 'is-focused',
            empty: 'is-empty',
        },
    });
    card.mount('#card-element');

    var inputs = document.querySelectorAll('input.field');
    Array.prototype.forEach.call(inputs, function(input) {
        input.addEventListener('focus', function() {
            input.classList.add('is-focused');
        });
        input.addEventListener('blur', function() {
            input.classList.remove('is-focused');
        });
        input.addEventListener('keyup', function() {
            if (input.value.length === 0) {
                input.classList.add('is-empty');
            } else {
                input.classList.remove('is-empty');
            }
        });
    });

    function setOutcome(result) {
        var errorElement = document.querySelector('.error');
        errorElement.classList.remove('visible');

        if (result.token) {
            // Token is created successfully
            document.getElementById('stripeToken').value = result.token.id; // Set the token value
        } else if (result.error) {
            errorElement.textContent = result.error.message;
            errorElement.classList.add('visible');
        }
    }

    card.on('change', function(event) {
        setOutcome(event);
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting immediately
        var form = document.querySelector('form');
        var extraDetails = {
            name: form.querySelector('input[name=cardholder-name]').value,
        };
        stripe.createToken(card, extraDetails).then(function(result) {
            setOutcome(result); // Call setOutcome to handle the result
            if (result.token) {
                // If the token is created successfully, set the token value in the hidden input
                document.getElementById('stripeToken').value = result.token.id;
                form.submit(); // Now submit the form
            }
        });
    });
</script>
</html>
