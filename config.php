<?php
// Only start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli(
    "sql100.infinityfree.com",
    "if0_40955533",
    "mtZdqJxIQ7cDDvy",
    "if0_40955533_quickquizdata"
);

if ($conn->connect_error) {
    die("Database connection failed");
}
?>
