<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
if (!isset($_COOKIE['email'])) {
    header("location:forgot-password.php");
    exit();
}

?>
<div class="signup-page">
    <div class="banner">
        <img src="./banners/login.png" alt="">
    </div>
    <div class="form">
        <div class="verification-container">
            <h1>OTP Verification</h1>
            <p>Enter the 6-digit code sent to your device</p>
            <div id="countdown-timer">Time remaining: 3:00</div>
            <div class="otp-fields">
                <input type="number" min="0" max="9" required>
                <input type="number" min="0" max="9" required>
                <input type="number" min="0" max="9" required>
                <input type="number" min="0" max="9" required>
                <input type="number" min="0" max="9" required>
                <input type="number" min="0" max="9" required>
            </div>
            <button class="verifyBtn" onclick="verifyCode()">Verify</button>
            <button id="resendButton" onclick="resendCode()" disabled>Resend OTP</button>
            <div class="error-message hidden" style="margin: 10px 0;">j</div>
        </div>

    </div>
</div>
<script>
    document.title = "Verify OTP - " + document.title;

    const inputs = document.querySelectorAll('.otp-fields input');
    const timerDisplay = document.getElementById('countdown-timer');
    const resendButton = document.getElementById('resendButton');
    const error = document.querySelector(".error-message");
    let timeLeft = parseInt(localStorage.getItem('timeLeft')) || 180; // Load timeLeft from localStorage or default to 180
    let timerId;

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    let email = getCookie('email');

    const showError = (message) => {
        if (message === '') {
            error.textContent = "h";
            error.classList.add("hidden");

        } else {
            error.textContent = message;
            error.classList.remove("hidden");
        }

    };

    function startTimer() {
        timerId = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(timerId);
                timerDisplay.textContent = "Code expired";
                resendButton.disabled = false;
                document.cookie = 'email' + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
                inputs.forEach(input => input.disabled = true);
                localStorage.removeItem('timeLeft'); // Remove timer from localStorage when expired
            } else {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerDisplay.textContent = `Time remaining: ${minutes}:${seconds.toString().padStart(2, '0')}`;
                timeLeft--;
                localStorage.setItem('timeLeft', timeLeft); // Save timer to localStorage
            }
        }, 1000);
    }

    function resendCode() {
        window.location.href = "./php/resend-otp.php?email=" + email;
    }

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            setTimeout(() => {
                e.target.value = e.target.value.replace(/\D/, '');
            }, 50);
            if (e.target.value.length > 1) {
                e.target.value = e.target.value.slice(0, 1);
            }
            if (e.target.value.length === 1) {
                if (index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value) {
                if (index > 0) {
                    inputs[index - 1].focus();
                }
            }
            if (e.key === 'e') {
                e.preventDefault();
            }
        });
    });

    function verifyCode() {
        const otp = Array.from(inputs).map(input => input.value).join('');
        if (otp.length === 6) {
            if (timeLeft > 0) {
                showError('');
                const verifyBtn = document.querySelector('.verifyBtn');
                verifyBtn.innerHTML = "Loading...";
                const formData = new FormData();
                formData.append("otp", otp);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "php/verify-otp.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = xhr.response;
                            if (response === "success") {
                                verifyBtn.innerHTML = "Verify";
                                localStorage.removeItem('timeLeft');
                                location.href = "set-password.php";
                            } else {
                                showError(response);
                                verifyBtn.innerHTML = "Verify";

                            }
                        } else {
                            showError("Error Occured");
                            verifyBtn.innerHTML = "Verify";
                        }
                    }
                };
                xhr.send(formData);
            } else {
                showError('OTP has expired. Please request a new one.');
            }
        } else {
            showError('Please enter a 6-digit OTP');
        }
    }

    startTimer();
</script>
<!-- <script>
    document.addEventListener("DOMContentLoaded", () => {
        document.title = "Forgot Password - " + document.title;
    

        // Form validation
        document.querySelector(".signup-form").addEventListener("submit", (event) => {
            event.preventDefault();
            const form = event.target;
            const email = form.querySelector("#email").value.trim();
            const errorMessage = form.querySelector(".error-message");

            let valid = true;

            // Clear previous error message

            // Function to add error messages
            const showError = (message) => {
                errorMessage.textContent = message;
                errorMessage.classList.remove("hidden");
                valid = false;
            };

            // Empty validation
            if (!email) {
                showError("Email should not be empty!");
                valid = false;
                return false;
            }

            // Email validation
            const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if (!email || !emailRegex.test(email)) {
                showError("Please enter a valid email address.");
                valid = false;
                return; // Stop further validation
            }

            if (valid) {
                const form = document.querySelector("#userLogin");
                const submitBtn = document.querySelector('.submitbtn');
                const formData = new FormData(form);
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "php/forgot-password.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            const response = xhr.response;
                            if (response === "success") {
                               
                                location.href = "verify-otp.php";
                            } else {
                                showError(response);
                            }
                        } else {
                            showError("Error Occured");
                        }
                    }
                };
                xhr.send(formData);
            }
        });
    });
</script> -->
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>