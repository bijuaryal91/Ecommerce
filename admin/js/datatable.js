// let currentPage = 1;
// const rowsPerPage = 5;

// document.addEventListener("DOMContentLoaded", function () {
//     updateTable();
//     document.getElementById("searchInput").addEventListener("keyup", function() {
//         searchTable();
//         updateTable();
//     });
// });

// function updateTable() {
//     const table = document.getElementById('dataTable');
//     const rows = Array.from(table.querySelectorAll('tbody tr'));
//     const filteredRows = rows.filter(row => row.style.display !== 'none');
//     const totalRows = filteredRows.length;
//     const totalPages = Math.ceil(totalRows / rowsPerPage);

//     // Hide all rows initially
//     rows.forEach(row => row.style.display = 'none');
    
//     // Show rows for the current page
//     const start = (currentPage - 1) * rowsPerPage;
//     const end = start + rowsPerPage;
//     filteredRows.slice(start, end).forEach(row => row.style.display = '');

//     // Update page number
//     document.getElementById('pageNumber').textContent = `Page ${currentPage} of ${totalPages}`;
// }

// function previousPage() {
//     if (currentPage > 1) {
//         currentPage--;
//         updateTable();
//     }
// }

// function nextPage() {
//     const table = document.getElementById('dataTable');
//     const rows = Array.from(table.querySelectorAll('tbody tr'));
//     const filteredRows = rows.filter(row => row.style.display !== 'none');
//     const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

//     if (currentPage < totalPages) {
//         currentPage++;
//         updateTable();
//     }
// }

// function searchTable() {
//     const searchInput = document.getElementById("searchInput").value.toLowerCase();
//     const rows = Array.from(document.querySelectorAll("#dataTable tbody tr"));

//     rows.forEach(row => {
//         const cells = Array.from(row.getElementsByTagName("td"));
//         const isMatch = cells.some(cell => cell.textContent.toLowerCase().includes(searchInput));
//         row.style.display = isMatch ? '' : 'none';
//     });

//     // Reset to the first page after search
//     currentPage = 1;
// }
