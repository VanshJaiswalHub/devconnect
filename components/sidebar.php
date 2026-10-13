<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-top">
            <div class="d-flex flex-column">
                <a href="dashboard.php" class="nav-link <?php echo ($current_page === 'dashboard.php') ? 'active' : ' '; ?>">
                    <i class="fa fa-th-large"></i> Dashboard
                </a>
                <a href="world.php" class="nav-link <?php echo ($current_page === 'world.php') ? 'active' : ' '; ?>">
                    <i class="fa fa-globe"></i> World
                </a>
                <a href="my_posts.php" class="nav-link <?php echo ($current_page === 'my_posts.php') ? 'active' : ' '; ?>">
                    <i class="fa fa-file"></i> My Posts
                </a>
                <a href="connections.php" class="nav-link <?php echo ($current_page === 'connections.php') ? 'active' : ' '; ?>">
                    <i class="fa fa-users"></i> Connections
                </a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal" class="nav-link">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">
                        Confirm Logout
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">
                    Are you sure you want to logout?
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <a href="logout.php" class="btn btn-danger">
                        Logout
                    </a>
                </div>

            </div>
        </div>
    </div>
</body>
