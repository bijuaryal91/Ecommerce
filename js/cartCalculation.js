document.addEventListener('DOMContentLoaded', () => {
    let cartUpdated = false;

    // Function to calculate the subtotal for each row
    function calculateRowSubtotal(row) {
        const price = parseFloat(row.querySelector('td:nth-child(2)').textContent.replace('Rs. ', ''));
        const quantity = parseInt(row.querySelector('input[type="number"]').value, 10);
        return price * quantity;
    }

    // Function to update the subtotal in each row
    function updateRowSubtotals() {
        const rows = document.querySelectorAll('.cart-list table tr');
        let subtotalTotal = 0;

        rows.forEach(row => {
            if (row.querySelector('input[type="number"]')) {
                const subtotalCell = row.querySelector('td:nth-child(4)');
                if (subtotalCell) {
                    const subtotal = calculateRowSubtotal(row);
                    subtotalCell.textContent = `Rs. ${subtotal}`;
                    subtotalTotal += subtotal;
                }
            }
        });

        // Assuming shipping cost is static (e.g., free)
        const shippingCost = 0;
        const total = subtotalTotal + shippingCost;

        // Update cart totals
        updateCartTotal(total);
        cartUpdated = true; // Mark cart as updated
    }

    // Function to update the cart total
    function updateCartTotal(total) {
        const subtotalElement = document.querySelector('.cart-total .subtotal:nth-child(2) p:nth-child(2)');
        const totalAmountElement = document.querySelector('.total-amount');

        if (subtotalElement) {
            subtotalElement.textContent = `Rs. ${total}`;
        }

        if (totalAmountElement) {
            totalAmountElement.textContent = `Rs. ${total}`;
        }
    }

    // Function to enforce minimum quantity
    function enforceMinQuantity(input) {
        if (parseInt(input.value, 10) < 1) {
            input.value = 1;
        }
    }

    // Event listener for quantity change
    document.querySelectorAll('.cart-list input[type="number"]').forEach(input => {
        // Set the min attribute to 1
        input.setAttribute('min', '1');
        
        input.addEventListener('input', () => {
            enforceMinQuantity(input);
            cartUpdated = false; // Set cartUpdated to false when quantity changes
            updateRowSubtotals();
        });
    });

    // Event listener for "Update Cart" button
    const updateCartButton = document.querySelector('.cart-action-button:nth-child(2)');
    if (updateCartButton) {
        updateCartButton.addEventListener('click', updateRowSubtotals);
    }

    // Event listener for "Proceed" button
    const proceedButton = document.querySelector('.cart-total .btn.btn-fluid');
    if (proceedButton) {
        proceedButton.addEventListener('click', () => {
            document.cookie = "isCameFromCart=true; path=/; SameSite=None; Secure";
            window.location.href="checkout.php";
        });
    }

    // Initial calculation
    updateRowSubtotals();
});
