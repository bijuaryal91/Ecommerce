<?php
include_once("./include/sidebar.php");
include_once('./php/connection.php');
?>
<style>
    body {
        overflow-x: visible;
    }

    .analytics {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .chart {
        border-radius: 8px; /* Rounded corners */
        padding: 20px; /* Inner spacing */ 
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css">
<main>
    <div class="header" style="align-items:start">
        <div class="left">
            <h1>Statistics</h1>
        </div>
    </div>

    <div class="container">
        <div class="analytics">
            <div id="barGraph" class="chart"></div>
            <div id="pieChart" class="chart"></div>
            <div id="ordersChart" class="chart"></div>
            <div id="lineGraph" class="chart"></div>
        </div>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.js"></script>
<script>
    // Function to fetch user counts from the PHP script
    async function fetchUserCounts() {
        try {
            const response = await fetch('./php/statistics/user-count.php'); // URL to PHP script
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const userCounts = await response.json(); // Get the count

            // Create the optionsLine object with the fetched data
            var optionsLine = {
                series: [{
                    name: "Users",
                    data: userCounts // Use the fetched data here
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: 'Total Users',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }
            };

            // Render the chart with the options
            var chart = new ApexCharts(document.querySelector("#lineGraph"), optionsLine);
            chart.render();

        } catch (error) {
            console.error('Error fetching user counts:', error);
        }
    }

    async function fetchOrderCounts() {
        try {
            const response = await fetch('./php/statistics/order-count.php'); // URL to PHP script
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const orderCounts = await response.json(); // Get the counts

            // Create the optionsLine object with the fetched data
            var optionsLine = {
                series: [{
                    name: "Orders",
                    data: orderCounts // Use the fetched data here
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                title: {
                    text: 'Total Orders',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                }
            };

            // Render the chart with the options
            var chart = new ApexCharts(document.querySelector("#ordersChart"), optionsLine);
            chart.render();

        } catch (error) {
            console.error('Error fetching order counts:', error);
        }
    }

    async function fetchMonthlySales() {
        try {
            const response = await fetch('./php/statistics/monthly-sales.php'); // URL to PHP script
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const salesData = await response.json(); // Get the sales data

            // Create the options for the bar graph
            var optionsBar = {
                series: [{
                    name: "Sales",
                    data: salesData, // Use the fetched sales data here

                }],
                chart: {
                    height: 350,
                    type: 'bar',
                },
                title: {
                    text: 'Monthly Sales',
                    align: 'left',
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                },
                dataLabels: {
                    enabled: true, // Enable data labels
                    style: {
                        colors: ['#000000'], // Set data label color to black
                    }
                },
            };



            // Render the chart with the options
            var chart = new ApexCharts(document.querySelector("#barGraph"), optionsBar);
            chart.render();

        } catch (error) {
            console.error('Error fetching monthly sales:', error);
        }
    }

    async function fetchCategoryData() {
        try {
            const response = await fetch('./php/statistics/category-data.php'); // URL to PHP script
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const categoryData = await response.json(); // Get the category data

            // Create the options for the pie chart
            var optionsPie = {
                series: categoryData.values, // Assuming categoryData.values is an array of values
                chart: {
                    height: 350,
                    type: 'pie',
                },
                title: {
                    text: 'Categories Distribution',

                },
                labels: categoryData.labels // Assuming categoryData.labels is an array of category names
            };

            // Render the chart with the options
            var chart = new ApexCharts(document.querySelector("#pieChart"), optionsPie);
            chart.render();

        } catch (error) {
            console.error('Error fetching category data:', error);
        }
    }

    // Call all the functions to fetch and render charts
    fetchUserCounts();
    fetchOrderCounts();
    fetchMonthlySales();
    fetchCategoryData();
</script>
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

</html>