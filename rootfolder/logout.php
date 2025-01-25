<?php
    session_start();
    unset($_SESSION["user-id"]);
    session_destroy();
    header("location:login.php");
?>