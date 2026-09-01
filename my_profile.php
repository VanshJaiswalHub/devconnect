<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: form_test.php");
    exit();
}

require "connection.php";

$userId = $_SESSION['user_id'];

$sql = "SELECT username, email, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$me = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile - DevConnect</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
        }
        nav {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        nav h3 {
            margin: 0;
            color: #333;
        }
        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
            font-size: 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .container {
            max-width: 400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 7px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        .card p {
            margin: 8px 0;
            color: #555;
        }
        .card-body-row {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        .user-avatar {
            width: 50px;
            height: 50px;
            min-width: 50px;
            border-radius: 50%;
            background: #4CAF50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 15px;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>

<nav>
    <h3>DevConnect</h3>
    <div>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>

<div class="container">
    <h2>My Profile</h2>
    <div class="card">
        <div class="card-body-row">
            <div class="d-flex align-items-start gap-3">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($me['username'], 0, 1)); ?>
                </div>
            </div>
            <div class="user-details">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($me['username']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($me['email']); ?></p>
                <p><strong>Member since:</strong> <?php echo date("F j, Y", strtotime($me['created_at'])); ?></p>
                <a href="dashboard.php" class="btn">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>