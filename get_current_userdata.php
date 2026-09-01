<?php
$userId = $_SESSION['user_id'];

$sql = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$me = $stmt->get_result()->fetch_assoc();
$stmt->close();