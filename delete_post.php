<?php

session_start();

require __DIR__ . "/includes/connection.php";
require __DIR__ . "/includes/auth_check.php";
require __DIR__ . '/includes/csrf.php';

$csrfToken = $_POST['csrf_token'] ?? '';

// Verify CSRF token
if (!verifyCsrfToken($csrfToken)) {
    exit("Invalid CSRF token.");
}

if (!isset($_POST['post_id'])) {
    exit("Invalid request.");
}

$postId = (int) $_POST['post_id'];
$userId = (int) $_SESSION['user_id'];

// Find the post only if it belongs to the logged-in user
$stmt = $conn->prepare("
    SELECT image_path
    FROM posts
    WHERE id = ? AND user_id = ?
");

$stmt->bind_param("ii", $postId, $userId);
$stmt->execute();

$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    exit("Post not found or you are not allowed to delete it.");
}

$imagePath = $post['image_path'];

// Delete the database record
$stmt = $conn->prepare("
    DELETE FROM posts
    WHERE id = ? AND user_id = ?
");

$stmt->bind_param("ii", $postId, $userId);
$stmt->execute();

if ($stmt->affected_rows === 1) {

    // Delete associated image
    if (!empty($imagePath)) {

        $filePath = __DIR__ . '/' . $imagePath;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

header("Location: world.php");
exit();