document.addEventListener("DOMContentLoaded", () => {
  document.title = "Signup - " + document.title;

  // Toggle password visibility
  const togglePasswordVisibility = (event) => {
    const passwordField = event.target.previousElementSibling;
    const isPassword = passwordField.type === "password";
    passwordField.type = isPassword ? "text" : "password";
    event.target.classList.toggle("fa-eye", isPassword);
    event.target.classList.toggle("fa-eye-slash", !isPassword);
  };

  document.querySelectorAll(".password-field i").forEach((icon) => {
    icon.addEventListener("click", togglePasswordVisibility);
  });

  // Form validation
  document.querySelector(".signup-form").addEventListener("submit", (event) => {
    event.preventDefault();
    const form = event.target;
    const fname = form.querySelector("#fname").value.trim();
    const lname = form.querySelector("#lname").value.trim();
    const email = form.querySelector("#email").value.trim();
    const phone = form.querySelector("#phone").value.trim();
    const password = form.querySelector("#password").value.trim();
    const cpassword = form.querySelector("#cpassword").value.trim();
    const errorMessage = form.querySelector(".error-message");
    const submitButton = form.querySelector('input[type="submit"]');

    let valid = true;
    let errorText = "";

    // Clear previous error message
    errorMessage.textContent = "";
    errorMessage.classList.add("hidden");

    // Function to add error messages
    const showError = (message) => {
      errorMessage.textContent = message;
      errorMessage.classList.remove("hidden");
      valid = false;
    };

    // Empty validation
    if (
      !fname ||
      !lname ||
      !email ||
      !phone ||
      !phone ||
      !password ||
      !cpassword
    ) {
      showError("All fields are required!");
      valid = false;
      return false;
    }
    if (fname.length < 2 || fname.length > 50) {
      showError("First Name must be between 2 and 50 characters.");
      valid = false;
      return false;
    }
    if (lname.length < 2 || lname.length > 50) {
      showError("Last Name must be between 2 and 50 characters.");
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

    // Phone number validation
    const phoneRegex = /^98\d{8}$/;
    if (!phone || !phoneRegex.test(phone)) {
      showError("Phone number must start with 98 and be 10 digits long.");
      valid = false;
      return; // Stop further validation
    }

    if (password.length < 8 || password.length > 20) {
      showError("Password must be between 8 and 20 characters long.");
      valid = false;
      return; // Stop further validation
    }
    if (password !== cpassword) {
      showError("Passwords do not match.");
      valid = false;
      return; // Stop further validation
    }

    if (valid) {
      // Change button text to "Loading..." and add animation class
      submitButton.value = "Loading...";
      submitButton.classList.add("loading");

      const formData = new FormData(form);
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "php/user-signup.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = xhr.response;
            if (response === "success") {
              alert("Check your mail for verification!");
              location.href = "login.php";
            } else {
              console.log(response);
              showError(response);
            }
          } else {
            showError("Error Occured");
          }

          // Revert button text and remove animation class
          submitButton.value = "Sign Up";
          submitButton.classList.remove("loading");
        }
      };
      xhr.send(formData);
    }
  });
});
