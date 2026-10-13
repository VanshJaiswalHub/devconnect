<?php

session_start();

require_once __DIR__ . "/includes/connection.php";
require_once __DIR__ . "/includes/csrf.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "You must be logged in."
    ]);
    exit;
}

if (
    !isset($_POST['csrf_token']) ||
    !verifyCsrfToken($_POST['csrf_token'])
) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid CSRF token."
    ]);
    exit;
}

$follower_id = (int) $_SESSION['user_id'];

if (!isset($_POST['following_id'])) {
    echo json_encode([
        "success" => false,
        "message" => "User ID is missing."
    ]);
    exit;
}

$following_id = (int) $_POST['following_id'];

if ($follower_id === $following_id) {
    echo json_encode([
        "success" => false,
        "message" => "You cannot follow yourself."
    ]);
    exit;
}

$stmt = $conn->prepare(
    "SELECT id
     FROM follows
     WHERE follower_id = ?
     AND following_id = ?"
);

$stmt->bind_param("ii", $follower_id, $following_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $follow_id = $row['id'];

    $delete_stmt = $conn->prepare(
        "DELETE FROM follows
         WHERE id = ?"
    );

    $delete_stmt->bind_param("i", $follow_id);
    $delete_stmt->execute();

    $delete_stmt->close();
    $stmt->close();

    echo json_encode([
        "success" => true,
        "following" => false
    ]);

} else {

    $insert_stmt = $conn->prepare(
        "INSERT INTO follows (follower_id, following_id)
         VALUES (?, ?)"
    );

    $insert_stmt->bind_param("ii", $follower_id, $following_id);
    $insert_stmt->execute();

    $insert_stmt->close();
    $stmt->close();

    echo json_encode([
        "success" => true,
        "following" => true
    ]);
}