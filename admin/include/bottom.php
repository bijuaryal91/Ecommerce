
</div>

<script src="./js/index.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
    $('#example').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: false,
        info: true,
        lengthChange: true
    });
});

</script>
</html>