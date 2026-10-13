<?php

require_once __DIR__ . '/includes/current_user.php';

$userId = $current_user['id'];

// ----------------------------------
// 1. Count user's posts
// ----------------------------------

$sql = "SELECT COUNT(*) AS total
        FROM posts
        WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$postCount = $result->fetch_assoc()['total'];

$stmt->close();


// ----------------------------------
// 2. Count followers
// ----------------------------------

$sql = "SELECT COUNT(*) AS total
        FROM follows
        WHERE following_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$followerCount = $result->fetch_assoc()['total'];

$stmt->close();


// ----------------------------------
// 3. Count following
// ----------------------------------

$sql = "SELECT COUNT(*) AS total
        FROM follows
        WHERE follower_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$followingCount = $result->fetch_assoc()['total'];

$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/style.css">
        <link rel="icon" type="image/svg+xml" href="assets/images/favicon.ico">
        <script src="assets/script.js" defer></script>


        <title>Dashboard - DevConnect</title>
    </head>

    <body>

        <!-- Topbar Section -->
        <?php include __DIR__ . '/components/topbar.php';?>

        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <main class="dashboard-main">
            <div class="dashboard-layout">
                <div class="dashboard-heading mb-4">

                <div>
                    <h1 class="mb-1">Dashboard</h1>

                    <p class="text-muted mb-0">
                        Your DevConnect activity and developer profile at a glance.
                    </p>
                </div>

            </div>
                <!-- Developer Summary -->
                <section class="developer-summary mb-4">
                    <div class="card p-4">

                        <div class="d-flex align-items-center gap-3">

                            <div class="user-chip-avatar">
                                <?php echo strtoupper(substr($current_user['username'], 0, 1)); ?>
                            </div>

                            <div>
                                <h3 class="mb-1">
                                    Welcome back,
                                    <?php echo htmlspecialchars($current_user['username']); ?> 👋
                                </h3>

                                <div class="text-muted">
                                    <?php echo htmlspecialchars($current_user['developer_role']); ?>
                                </div>
                            </div>

                        </div>

                        <div class="mt-3">

                            <?php if ($current_user['experience_years'] !== null): ?>

                                <span class="badge bg-success">
                                    <?php echo (int) $current_user['experience_years']; ?>
                                    <?php echo ((int) $current_user['experience_years'] === 1) ? 'year' : 'years'; ?>
                                    experience
                                </span>

                            <?php else: ?>

                                <span class="badge bg-secondary">
                                    Experience not specified
                                </span>

                            <?php endif; ?>

                            <span class="text-muted ms-2">
                                <?php echo htmlspecialchars($current_user['email']); ?>
                            </span>

                        </div>

                    </div>
                </section>


                <!-- DevConnect Stats -->
                <section class="devconnect-stats">

                    <div class="row g-3">

                        <div class="col-md-3">
                            <div class="dashboard-stat-card h-100">

                                <div class="stat-icon">
                                    <i class="fa fa-file-text-o"></i>
                                </div>

                                <div class="text-muted small">
                                    Posts
                                </div>

                                <h3 class="mb-0">
                                    <?php echo $postCount; ?>
                                </h3>

                            </div>
                        </div>

                        <!-- Followers -->
                        <div class="col-md-3">
                            <div class="dashboard-stat-card h-100">

                                <div class="stat-icon">
                                    <i class="fa fa-users"></i>
                                </div>

                                <div class="text-muted small">
                                    Followers
                                </div>

                                <h3 class="mb-0">
                                    <?php echo $followerCount; ?>
                                </h3>

                            </div>
                        </div>

                        <!-- Following -->
                        <div class="col-md-3">
                            <div class="dashboard-stat-card h-100">

                                <div class="stat-icon">
                                    <i class="fa fa-user-plus"></i>
                                </div>

                                <div class="text-muted small">
                                    Following
                                </div>

                                <h3 class="mb-0">
                                    <?php echo $followingCount; ?>
                                </h3>

                            </div>
                        </div>

                        <!-- Joined -->
                        <div class="col-md-3">
                            <div class="dashboard-stat-card h-100">

                                <div class="stat-icon">
                                    <i class="fa fa-calendar"></i>
                                </div>

                                <div class="text-muted small">
                                    Joined
                                </div>

                                <h3 class="mb-0">
                                    <?php echo date('M Y', strtotime($current_user['created_at'])); ?>
                                </h3>

                            </div>
                        </div>

                    </div>
                </section>
            </div>
        </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>