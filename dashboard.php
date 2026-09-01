<?php

require "auth_check.php";
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/style.css">

        <title>Dashboard - DevConnect</title>
    </head>

    <body>
        <!-- Topbar Section -->

        <div class="top-bar d-flex align-items-center justify-content-between">

            <div class="d-flex align-items-center gap-3">
                <div class="topbar-icon-btn">
                    <i class="fa fa-comment"></i>
                </div>
                <div class="avatar-strip d-flex gap-2 ms-2">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <div class="avatar-sm" title="No friends online yet">
                            <i class="fa fa-user"></i>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <i class="fa fa-bell topbar-utility-icon" title="Notifications (coming soon)"></i>
                <i class="fa fa-cog topbar-utility-icon" title="Settings (coming soon)"></i>

                <div class="d-flex align-items-center gap-2 ms-2">
                    <div class="user-chip-avatar">
                        <?php echo strtoupper(substr($me['username'], 0, 1)); ?>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-bold small"><?php echo htmlspecialchars($me['username']); ?></div>
                        <div class="text-muted" style="font-size: 12px;"><?php echo htmlspecialchars($me['email']); ?></div>
                    </div>
                    <i class="fa fa-chevron-down text-muted small"></i>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <!-- Sidebar -->
            <nav class="sidebar">
                <div class="sidebar-top">
                    <h3><i class="fa fa-desktop"></i> DevConnect</h3>
                    <div class="d-flex flex-column">
                        <a href="dashboard.php" class="nav-link active">
                            <i class="fa fa-th-large"></i> Dashboard
                        </a>
                        <a href="world.php" class="nav-link">
                            <i class="fa fa-globe"></i> World
                        </a>
                        <a href="my_profile.php" class="nav-link">
                            <i class="fa fa-user"></i> My Profile
                        </a>
                        <a href="#members" class="nav-link">
                            <i class="fa fa-users"></i> Friends
                        </a>
                        <a href="logout.php" class="nav-link">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>
                    </div>
                </div>
                    <div class="user-avatar d-flex align-items-center gap-2 ms-2">
                <div class="user-chip-avatar">
                    <?php echo strtoupper(substr($me['username'], 0, 1)); ?>
                </div>
                <div class="d-none d-md-block">
                    <div class="fw-bold small"><?php echo htmlspecialchars($me['username']); ?></div>
                    <div class="text-muted" style="font-size: 12px;"><?php echo htmlspecialchars($me['email']); ?></div>
                </div>
                <i class="fa fa-chevron-down text-muted small"></i>
                </div>
            </nav>

            <main>

                <!-- Main Content -->
                <div class = "main-layout">
                    <!-- Left: Chat/contact list -->
                    <div class="col-md-7 chatbox">
                        <div class="card p-3">
                            <div class="card-header">
                                <h5>DevConnecting...</h5>
                            </div>
                            <div class="card-chatlist">
                                <!-- Placeholder contact cards - swap for real data later -->
                                <?php
                                $placeholderContacts = ["Alex Stein", "Malcolm D.", "Steven H.", "Lucy Weir", "Karolina P.", "Chris C.", "Tom E.", "Stephan I.","Andrew S."];
                                foreach ($placeholderContacts as $name):
                                ?>
                                    <div class="d-flex align-items-center p-2 mb-2 rounded contact-item" style="cursor: pointer;">
                                        <div class="user-chip-avatar me-3">
                                            <?php echo strtoupper(substr($name, 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold small"><?php echo htmlspecialchars($name); ?></div>
                                            <div class="text-muted" style="font-size: 12px;">No messages yet</div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Selected contact's profile -->
                    <div class="col-md-5 chat-profile">
                        <div class="card p-4 text-center">
                            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                <i class="fa fa-user-circle-o fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Select a contact to view their profile</p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Left: 1/3 - Profile summary -->
                <!-- <div class="col-md-4 d-flex mb-4 mb-md-0">
                    <div class="card w-100 p-4 text-center">
                        <div class="card-body">
                            <div class="avatar-circle">
                                <i class="fa fa-user"></i>
                            </div>
                            <h5 class="mb-1"><?php echo htmlspecialchars($me['username']); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($me['email']); ?></p>
                            <p class="small text-muted mb-4">
                                Member since <?php echo date("F Y", strtotime($me['created_at'])); ?>
                            </p>
                            <a href="my_profile.php" class="btn btn-outline-success btn-sm w-100">
                                <i class="fa fa-id-card me-1"></i> View Full Profile
                            </a>
                        </div>
                    </div>
                </div> -->

                <!-- Right: 2/3 - Friends -->
                <!-- <div class="col-md-8 d-flex" id="members">
                    <div class="card w-100 p-4 d-flex align-items-center justify-content-center text-center">
                        <div class="card-body">
                            <i class="fa fa-users fa-3x text-muted mb-3"></i>
                            <p class="fs-5 mb-1">Friends</p>
                            <p class="text-muted mb-4">No friends online right now</p>
                            <button class="btn btn-success px-4" disabled title="Coming soon">
                                <i class="fa fa-user-plus me-1"></i> Add Friends
                            </button>
                        </div>
                    </div>
                </div> -->
            </main>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>