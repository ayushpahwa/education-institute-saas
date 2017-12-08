<?php ob_start();
    session_start();if(isset($_SESSION['email'])){
         session_destroy();}
               header("Location: http://panel.brinjal.in/portal/login.php");
                     exit();?>