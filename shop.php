<?php
ob_start();
include_once("./includes/header.php");
include_once("./includes/navbar.php");
include_once("./includes/connect.php");

?>



<script>
    document.title = "Shops - "+document.title;
</script>
<?php
include_once('./includes/footer-menu.php');
include_once('./includes/footer.php');
?>