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

      // Validation
      if (!name || !email || !phone || !message) {
        showError("All fields are required!");
        return;
      }

      if (name.length < 4 || name.length > 50) {
        showError("Name must be between 4 and 50 characters.");
        return;
      }

      // Email validation
      const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (!emailRegex.test(email)) {
        showError("Please enter a valid email address.");
        return;
      }

      // Phone number validation
      const phoneRegex = /^98\d{8}$/;
      if (!phoneRegex.test(phone)) {
        showError("Phone number must start with 98 and be 10 digits long.");
        return;
      }

      // Message length validation
      if (message.length < 100) {
        showError("Message must be at least 100 characters long.");
        return;
      }

      // If everything is valid, reset the form
      if (valid) {
        errorMessage.classList.add("hidden");
        document.querySelector('.send-contact').innerHTML="Loading...";
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "php/send-contact.php", true);
        xhr.onreadystatechange = function () {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              const response = xhr.response;
              if (response === "success") {
                form.reset();
                document.querySelector('.send-contact').innerHTML="Send Message";
                location.href = "contact.php";
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
