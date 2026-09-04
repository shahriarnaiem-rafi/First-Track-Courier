<?php

$database = mysqli_connect("localhost", "root", "", "fasttrack");

if (!$database) {
    die("Database connection failed.");
}

mysqli_set_charset($database, "utf8mb4");