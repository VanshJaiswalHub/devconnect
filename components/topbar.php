<?php
require_once __DIR__ . '/../includes/current_user.php';
?>

<!-- Topbar Section -->

<div class="top-bar d-flex align-items-center justify-content-between">

    <div class="d-flex align-items-center gap-2">

        <!-- Hamburger button -->
        <button type="button" class="mobile-menu-toggle"
            id="sidebarToggle"
            aria-label="Toggle sidebar"
            aria-controls="appSidebar"
            aria-expanded="true">
            <i class="fa fa-bars"></i>
        </button>

        <!-- DevConnect logo -->
        <div class="topbar-icon-btn">
            <a href="dashboard.php" class="d-flex align-items-center gap-2 text-decoration-none text-light">
                <img src="assets/images/logo.png" alt="DevConnect" width="40" height="40">
                <h2 class="mb-0">DevConnect</h2>
            </a>
        </div>
    </div>

    <div class="d-flex align-items-center gap-3">
        <i class="fa fa-bell topbar-utility-icon" title="Notifications (coming soon)"></i>
        <i class="fa fa-cog topbar-utility-icon" title="Settings (coming soon)"></i>

        <div class="d-flex align-items-center gap-2 ms-2">
            <div class="user-chip-avatar">
                <?php echo strtoupper(substr($current_user['username'], 0, 1)); ?>
            </div>
            <div class="d-none d-md-block">
                <div class="fw-bold small"><?php echo htmlspecialchars($current_user['username']); ?></div>
                <div class="text-muted" style="font-size: 12px;"><?php echo htmlspecialchars($current_user['email']); ?></div>
            </div>
            <i class="fa fa-chevron-down text-muted small"></i>
        </div>
    </div>
</div>