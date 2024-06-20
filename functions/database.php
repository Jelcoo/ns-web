<?php

$conn = new mysqli(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASSWORD"), getenv("DB_NAME"));

if ($conn->connect_error) {
    if (getenv("DEBUG") == "true") {
        die("Database connection failed: " . $conn->connect_error);
    }
    die("Database connection failed! Please contact site admin.");
}

return $conn;
