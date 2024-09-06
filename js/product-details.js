function updateMainImage(src) {
  document.getElementById("main-image").src = src;
}

function changeQuantity(amount) {
  const quantityInput = document.getElementById("quantity");
  let currentQuantity = parseInt(quantityInput.value);
  currentQuantity += amount;
  if (currentQuantity < 1) currentQuantity = 1;
  if (currentQuantity > 10) currentQuantity = 10;
  quantityInput.value = currentQuantity;
}
