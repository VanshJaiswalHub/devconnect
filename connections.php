<?php

require_once __DIR__ . '/includes/current_user.php';
require_once __DIR__ . '/includes/csrf.php';

$userId = $current_user['id'];

// ----------------------------------
// Following
// ----------------------------------

$sql = "SELECT
            users.id,
            users.username,
            users.developer_role,
            users.experience_years
        FROM follows
        JOIN users
            ON follows.following_id = users.id
        WHERE follows.follower_id = ?
        ORDER BY follows.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();

$followingUsers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close();

// ----------------------------------
// Followers
// ----------------------------------

$sql = "SELECT
            users.id,
            users.username,
            users.developer_role,
            users.experience_years
        FROM follows
        JOIN users
            ON follows.follower_id = users.id
        WHERE follows.following_id = ?
        ORDER BY follows.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$followerUsers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$followingCount = count($followingUsers);
$followerCount = count($followerUsers);
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">

        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">

        <title>Connections - DevConnect</title>

        <link rel="icon" href="assets/images/favicon.ico">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="assets/style.css">

        <script src="assets/script.js" defer></script>

    </head>

    <body>

        <?php include __DIR__ . '/components/topbar.php'; ?>

        <?php include __DIR__ . '/components/sidebar.php'; ?>

        <main class="dashboard-main">

            <div class="connections-page">

                <!-- Heading -->

                <div class="connections-header">

                    <div>

                        <h1>Connections</h1>

                        <p>
                            Manage your developer network.
                        </p>

                    </div>

                </div>


                <!-- Stats -->

                <div class="connection-stats">

                    <div class="connection-stat">

                        <div class="connection-stat-icon">
                            <i class="fa fa-user-plus"></i>
                        </div>

                        <div>
                            <strong>
                                <?php echo $followingCount; ?>
                            </strong>

                            <span>Following</span>
                        </div>

                    </div>


                    <div class="connection-stat">

                        <div class="connection-stat-icon">
                            <i class="fa fa-users"></i>
                        </div>

                        <div>
                            <strong>
                                <?php echo $followerCount; ?>
                            </strong>

                            <span>Followers</span>
                        </div>

                    </div>

                </div>


                <!-- Tabs -->

                <div class="connection-tabs">

                    <button
                        type="button"
                        class="connection-tab active"
                        data-tab="following">

                        Following

                        <span>
                            <?php echo $followingCount; ?>
                        </span>

                    </button>


                    <button
                        type="button"
                        class="connection-tab"
                        data-tab="followers">

                        Followers

                        <span>
                            <?php echo $followerCount; ?>
                        </span>

                    </button>

                </div>


                <!-- Following -->

                <div
                    class="connection-list"
                    id="following-list">

                    <?php if (empty($followingUsers)): ?>

                        <div class="connections-empty">

                            <i class="fa fa-user-plus"></i>

                            <h3>No developers followed yet</h3>

                            <p>
                                Explore the community and connect
                                with other developers.
                            </p>

                            <a href="world.php">
                                Explore Developers
                            </a>

                        </div>

                    <?php else: ?>

                        <?php foreach ($followingUsers as $user): ?>

                            <div class="connection-card">

                                <div class="connection-avatar">
                                    <?php
                                    echo strtoupper(
                                        substr($user['username'], 0, 1)
                                    );
                                    ?>
                                </div>


                                <div class="connection-info">

                                    <h3>
                                        <?php
                                        echo htmlspecialchars(
                                            $user['username']
                                        );
                                        ?>
                                    </h3>

                                    <p>
                                        <?php
                                        echo htmlspecialchars(
                                            $user['developer_role']
                                        );
                                        ?>
                                    </p>

                                    <?php if ($user['experience_years'] !== null): ?>

                                        <span class="connection-experience">
                                            <?php
                                            echo (int) $user['experience_years'];
                                            ?>
                                            <?php
                                            echo $user['experience_years'] == 1
                                                ? 'year experience'
                                                : 'years experience';
                                            ?>
                                        </span>

                                    <?php endif; ?>

                                </div>

                                <div class="connection-action">
                                    <button
                                        type="button"
                                        class="btn btn-outline-danger unfollow-btn"
                                        data-user-id="<?php echo (int) $user['id']; ?>"
                                        data-username="<?php echo htmlspecialchars($user['username']); ?>"
                                    >
                                        Unfollow
                                    </button>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>


                <!-- Followers -->

                <div
                    class="connection-list"
                    id="followers-list"
                    style="display: none;">

                    <?php if (empty($followerUsers)): ?>

                        <div class="connections-empty">

                            <i class="fa fa-users"></i>

                            <h3>No followers yet</h3>

                            <p>
                                Share your work and build your
                                developer network.
                            </p>

                            <a href="world.php">
                                Explore Community
                            </a>

                        </div>

                    <?php else: ?>

                        <?php foreach ($followerUsers as $user): ?>

                            <div class="connection-card">

                                <div class="connection-avatar">
                                    <?php
                                    echo strtoupper(
                                        substr($user['username'], 0, 1)
                                    );
                                    ?>
                                </div>


                                <div class="connection-info">

                                    <h3>
                                        <?php
                                        echo htmlspecialchars(
                                            $user['username']
                                        );
                                        ?>
                                    </h3>

                                    <p>
                                        <?php
                                        echo htmlspecialchars(
                                            $user['developer_role']
                                        );
                                        ?>
                                    </p>

                                    <?php if ($user['experience_years'] !== null): ?>

                                        <span class="connection-experience">
                                            <?php
                                            echo (int) $user['experience_years'];
                                            ?>
                                            <?php
                                            echo $user['experience_years'] == 1
                                                ? 'year experience'
                                                : 'years experience';
                                            ?>
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </div>

        </main>

        <div
            class="modal fade"
            id="unfollowModal"
            tabindex="-1"
            aria-labelledby="unfollowModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="unfollowModalLabel">
                            <strong>Unfollow</strong>
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to unfollow
                        <strong id="unfollowUsername"></strong>?
                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <form action="follow_action.php" method="POST">
                            <input
                                type="hidden"
                                name="action"
                                value="unfollow"
                            >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars(generateCsrfToken()); ?>"
                            >

                            <input
                                type="hidden"
                                name="following_id"
                                id="unfollowUserId"
                            >

                            <button
                                type="submit"
                                class="btn btn-danger"
                            >
                                Unfollow
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>

        <!-- CONNECTIONS-DEBUG-2026 -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>

    </body>

</html>