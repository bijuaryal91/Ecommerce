<?php

session_start();
if(isset($_SESSION['user_status']))
{
   
            session_unset();
            session_destroy();
            header("location: ../login.php");
}
else
{
    header("location: ../login.php");
}

?>