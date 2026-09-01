<?php
require "auth_check.php";
require "connection.php";

$userId = $_SESSION['user_id'];
$content = trim($_POST['content'] ?? '');
$imagePath = null;

// Handle image upload if one was provided
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = mime_content_type($_FILES['image']['tmp_name']);

    if (in_array($fileType, $allowedTypes)) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newFileName = $userId . '_' . time() . '.' . $ext;
        $destination = 'assets/uploads/posts/' . $newFileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $imagePath = $destination;
        }
    }
}

// Require at least text or an image — keep NULL (not empty string) when absent,
// so it lines up cleanly with a DB-level CHECK constraint if you add one later
if ($content === '') {
    $content = null;
}

if ($content === null && $imagePath === null) {
    header("Location: world.php?error=empty");
    exit();
}

$stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_path) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $userId, $content, $imagePath);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: world.php");
exit();