document.addEventListener("DOMContentLoaded", () => {
  document.title = "Signin - " + document.title;
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
    const email = form.querySelector("#email").value.trim();
    const password = form.querySelector("#password").value.trim();
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
    if (!email || !password) {
      showError("All fields are required!");
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

    if (password.length < 8 || password.length > 20) {
      showError("Password must be between 8 and 20 characters long.");
      valid = false;
      return; // Stop further validation
    }

    if (valid) {
      const form = document.querySelector("#userLogin");
      const formData = new FormData(form);
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "php/user-login.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = xhr.response;
            if (response === "success") {
              location.href = "index.php";
            } else {
              showError(response);
            }
          } 
          else {
            showError("Error Occured");
          }
        }
      };
      xhr.send(formData);
    }
  });
});
