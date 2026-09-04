<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user-id'])) {
    header("Location: ../../rootfolder/login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../rootfolder/login.php");
    exit();
}