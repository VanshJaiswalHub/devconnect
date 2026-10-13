<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS'],
    $_ENV['DB_NAME']
);

if ($conn->connect_error) {
    error_log("DevConnect database connection failed: " . $conn->connect_error);

    http_response_code(500);
    exit("Something went wrong. Please try again later.");
}