<?php
include_once("./include/sidebar.php");
include_once('./php/connection.php');
?>
<style>
    body {
        overflow-x: visible;
    }
</style>
<main>
    <div class="header" style="align-items:start">
        <div class="left">
            <h1>Generate Report</h1>
        </div>
        <div class="reports">

            <div class="date-range-wrapper">
                <input type="text" id="dateRangeInput" placeholder="Select Date Range" readonly />
                <div class="dropdown-menu" id="dropdownMenu">
                    <ul>
                        <li data-range="today">Today</li>
                        <li data-range="yesterday">Yesterday</li>
                        <li data-range="last7days">Last 7 Days</li>
                        <li data-range="last15days">Last 15 Days</li>
                        <li data-range="thisMonth">This Month</li>
                        <li data-range="lastMonth">Last Month</li>
                        <li data-range="thisYear">This Year</li>
                        <li data-range="custom">Custom Date</li>
                    </ul>
                </div>
                <div class="calendar-wrapper" id="calendarWrapper">
                    <input type="date" id="startDate" />
                    <input type="date" id="endDate" />
                    <button id="applyCustomDate">Apply</button>
                </div>
            </div>

        </div>
    </div>

    <div class="container" style="visibility: hidden;">
        <div class="analytics">
            <ul class="insights">
                <li>
                    <i class='bx bx-calendar-check'></i>
                    <span class="info">
                        <h3 class="orderinfo">
                            
                        </h3>
                        <p>Orders</p>
                    </span>
                </li>
              
                <li><i class='bx bx-show-alt'></i>
                    <span class="info">
                        <h3 class="customerinfo">
                          
                        </h3>
                        <p>Customers</p>
                    </span>

                </li>
              
                <li><i class='bx bx-line-chart'></i>
                    <span class="info">
                        <h3 class="productinfo">
                          
                        </h3>
                        <p>Products</p>
                    </span>
                </li>
               

                
                <li><i class='bx bx-dollar-circle'></i>
                    <span class="info">
                        <h3 class="salesinfo">
                        
                        </h3>
                        <p>Total Sales</p>
                    </span>
                </li>


            </ul>
            <!-- End of Insights -->
        </div>

    </div>

</main>
<script>
    function printOrders() {
        var containerContent = document.querySelector('table').outerHTML;
        var printWindow = window.open('', '', 'height=500,width=800');
        printWindow.document.write('<html><head><title>Print Container</title>');
        printWindow.document.write('</head><body >');
        printWindow.document.write(containerContent);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
</script>
<script>
    // Get the current page's path
    const currentPath = window.location.pathname;

    // Select all the <li> elements
    const menuItems = document.querySelectorAll('.side-menu li');

    // Loop through the <li> elements
    menuItems.forEach(item => {
        // Get the <a> tag and its href attribute
        const link = item.querySelector('a');
        const href = link.getAttribute('href');

        // Check if the currentPath matches the href
        if (currentPath.includes(href)) {
            // Add the 'active' class to the corresponding <li>
            item.classList.add('active');

            // Change the document title based on the active menu item's text
            document.title = link.textContent.trim() + " - RK Stores";
        } else {
            // Remove the 'active' class if it doesn't match
            item.classList.remove('active');
        }
    });
</script>

</div>

<script src="./js/index.js"></script>
</body>

<script>
    // Get elements
    const dateRangeInput = document.getElementById('dateRangeInput');
    const dropdownMenu = document.getElementById('dropdownMenu');
    const calendarWrapper = document.getElementById('calendarWrapper');
    const startDate = document.getElementById('startDate');
    const endDate = document.getElementById('endDate');
    const applyCustomDate = document.getElementById('applyCustomDate');

    // Toggle dropdown menu
    dateRangeInput.addEventListener('click', () => {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        calendarWrapper.style.display = 'none'; // Hide calendar when menu opens
    });

    // Predefined date range options
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(today.getDate() - 1);

    const formatDate = (date) => {
        return date.toISOString().split('T')[0]; // Format date as YYYY-MM-DD
    };


    // Apply custom date range
    // Function to fetch analytics from the backend
    function fetchAnalytics(startDate, endDate) {
        fetch('./php/getAnalytics.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `startDate=${startDate}&endDate=${endDate}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    displayAnalytics(data);
                }
            })
            .catch(error => console.error('Error fetching analytics:', error));
    }

    // Function to display analytics
    function displayAnalytics(data) {
        const totalOrdersElement = document.querySelector('.orderinfo');
        const totalAmountElement = document.querySelector('.salesinfo');
        const products = document.querySelector('.productinfo');
        const customers = document.querySelector('.customerinfo');
        let amount = Number(data.totalAmount);
        totalOrdersElement.textContent = data.totalOrders;
        totalAmountElement.textContent = amount.toLocaleString();
        products.textContent=data.totalProducts;
        customers.textContent=data.totalCustomers;
        document.querySelector('.container').style.visibility="visible";
    }

    // Modify event listener for predefined date range
    dropdownMenu.addEventListener('click', (event) => {
        const option = event.target.getAttribute('data-range');
        let rangeStart = '';
        let rangeEnd = formatDate(today);

        switch (option) {
            case 'today':
                rangeStart = formatDate(today);
                break;
            case 'yesterday':
                rangeStart = formatDate(yesterday);
                rangeEnd = formatDate(yesterday);
                break;
            case 'last7days':
                const last7days = new Date(today);
                last7days.setDate(today.getDate() - 6);
                rangeStart = formatDate(last7days);
                break;
            case 'last15days':
                const last15days = new Date(today);
                last15days.setDate(today.getDate() - 14);
                rangeStart = formatDate(last15days);
                break;
            case 'thisMonth':
                rangeStart = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-01`;
                break;
            case 'lastMonth':
                const lastMonth = new Date(today);
                lastMonth.setMonth(today.getMonth() - 1);
                rangeStart = `${lastMonth.getFullYear()}-${String(lastMonth.getMonth() + 1).padStart(2, '0')}-01`;
                rangeEnd = `${lastMonth.getFullYear()}-${String(lastMonth.getMonth() + 1).padStart(2, '0')}-${new Date(lastMonth.getFullYear(), lastMonth.getMonth() + 1, 0).getDate()}`;
                break;
            case 'thisYear':
                rangeStart = `${today.getFullYear()}-01-01`;
                break;
            case 'custom':
                dropdownMenu.style.display = 'none';
                calendarWrapper.style.display = 'block';
                return; // Skip updating input
        }
        console.log(rangeStart + " to " + rangeEnd);
        dateRangeInput.value = `${rangeStart} to ${rangeEnd}`;
        dateRangeInput.classList.add('highlight');
        setTimeout(() => dateRangeInput.classList.remove('highlight'), 400); // Remove highlight after animation
        dropdownMenu.style.display = 'none'; // Hide dropdown after selection


        // Same logic as before to calculate rangeStart and rangeEnd...
        // After calculating the range, fetch analytics:
        fetchAnalytics(rangeStart, rangeEnd);
    });

    // Modify event listener for custom date range
    applyCustomDate.addEventListener('click', () => {
        const customRangeStart = startDate.value;
        const customRangeEnd = endDate.value;

        if (customRangeStart && customRangeEnd) {
            dateRangeInput.value = `${customRangeStart} to ${customRangeEnd}`;
            dateRangeInput.classList.add('highlight');
            setTimeout(() => dateRangeInput.classList.remove('highlight'), 400);
            calendarWrapper.style.display = 'none';
        


            // Fetch analytics for the custom date range
            fetchAnalytics(customRangeStart, customRangeEnd);
        } else {
            alert('Please select both start and end dates');
        }
    });
</script>

</html>