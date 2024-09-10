document.addEventListener("DOMContentLoaded", () => {
  // Function to validate the billing form
  const validateBillingForm = (event) => {
    event.preventDefault(); // Prevent default button behavior

    const form = document.querySelector(".billing-form");
    const fields = {
      name: form.querySelector("#name").value.trim(),
      address: form.querySelector("#cname").value.trim(),
      street: form.querySelector("#street").value.trim(),
      town: form.querySelector("#town").value.trim(),
      phone: form.querySelector("#phone").value.trim(),
    };
    const errorMessage = document.querySelector(".coupon-error");
    const paymentMethod = document.querySelector('input[type="radio"]:checked');

    let valid = true;

    // Clear previous error message
    errorMessage.textContent = "";
    errorMessage.classList.add("hidden");

    // Function to add error messages
    const showError = (message) => {
      errorMessage.textContent = message;
      errorMessage.classList.remove("hidden");
      valid = false;
    };

    // Empty field validation
    for (let key in fields) {
      if (fields[key] === "") {
        showError("All fields marked with * are required!");
        return;
      }
    }

    // Email validation
    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!emailRegex.test(document.querySelector('#email').value)) {
      showError("Please enter a valid email address.");
      return;
    }

    // Phone number validation (optional)
    const phoneRegex = /^98\d{8}$/; // Adjust regex as needed
    if (!phoneRegex.test(fields.phone)) {
      showError("Please enter a valid phone number.");
      return;
    }

    if (!paymentMethod) {
      showError("Please select a payment method.");
      return;
    }


    if (valid) {
      // Send form data via AJAX
      const formData = new FormData(form);
      // Append selected payment method to the form data

      let discountedPrice = document.querySelector(".discounted");
      discountedPrice = discountedPrice.textContent.replace('Rs.','');
      formData.append("payment_method", paymentMethod.value);
      formData.append("email", document.querySelector('#email').value);
      formData.append("discountedPrice",discountedPrice);
      formData.append("apart",form.querySelector("#apart").value.trim())

      const xhr = new XMLHttpRequest();
      xhr.open("POST", "php/billing-update.php", true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = xhr.responseText;
            if (response === "cod") {
              // Handle success (e.g., redirect or show success message)
              console.log("success");
              location.href = "order-success.php";
            } else if (response === "stripe") {
              location.href = "stripe-payment.php";
              console.log("success");

            } else {
              showError(response);
            }
          } else {
            showError("Error occurred during form submission.");
          }
        }
      };
      xhr.send(formData);
    }
  };

  // Attach validation to the button click
  document
    .querySelector(".place-order button")
    .addEventListener("click", validateBillingForm);
});
