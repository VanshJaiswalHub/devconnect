<?php

require_once "auth_check.php";
require_once "connection.php";

$userId = $_SESSION['user_id'];

$sql = "SELECT id, username, email, developer_role, experience_years, created_at
        FROM users
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$current_user = $stmt->get_result()->fetch_assoc();

$stmt->close();