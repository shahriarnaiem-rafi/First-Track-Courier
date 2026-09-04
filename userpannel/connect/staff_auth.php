<?php

session_start();

if (!isset($_SESSION['user-id'])) {
    header("Location: ../rootfolder/login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Staff') {
    header("Location: ../rootfolder/login.php");
    exit();
}