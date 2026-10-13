<?php

require_once __DIR__ . '/includes/current_user.php';
require_once __DIR__ . '/includes/csrf.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: connections.php");
    exit;
}

$csrfToken = $_POST['csrf_token'] ?? '';

if (!verifyCsrfToken($csrfToken)) {
    die("Invalid request.");
}

$followingId = (int) ($_POST['following_id'] ?? 0);

if ($followingId <= 0) {
    header("Location: connections.php");
    exit;
}

$sql = "DELETE FROM follows
        WHERE follower_id = ?
        AND following_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ii",
    $userId,
    $followingId
);

$stmt->execute();

$stmt->close();
$conn->close();

header("Location: connections.php");
exit;