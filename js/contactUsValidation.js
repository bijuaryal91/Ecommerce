document.addEventListener("DOMContentLoaded", () => {
  document.title = "Contact - " + document.title;
  // Form validation
  document
    .querySelector(".contact-form form")
    .addEventListener("submit", (event) => {
      event.preventDefault();
      const form = event.target;
      const name = form.querySelector("#name").value.trim();
      const email = form.querySelector("#email").value.trim();
      const phone = form.querySelector("#phone").value.trim();
      const message = form.querySelector("#message").value.trim();
      const errorMessage = form.querySelector(".error-message");

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
      if (!name || !email || !phone || !message) {
        showError("All fields are required!");
        valid = false;
        return false;
      }
      if (name.length < 4 || name.length > 50) {
        showError("Name must be between 4 and 50 characters.");
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

     if(message.length<100)
     {
        showError("Message must be at least 100 characters long");
        valid = false;
        return; 
     }

      if (valid) {
        errorMessage.classList.add("hidden");
        alert("form submitted");
      }
    });
});
