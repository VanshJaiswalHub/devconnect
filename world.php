<?php
require "auth_check.php";
require "connection.php";
require "get_current_userdata.php";

$postsPerPage = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $postsPerPage;

$sql = "SELECT posts.id, posts.user_id, posts.content, posts.image_path, posts.created_at, users.username
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC
        LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $postsPerPage, $offset);
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Suggested people to follow (no real "follow" system yet — display only)
$sql = "SELECT id, username FROM users WHERE id != ? ORDER BY RAND() LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$suggestedUsers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DevConnect - World</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/style.css">
    </head>

    <!-- Body Section -->

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
                        <a href="dashboard.php" class="nav-link">
                            <i class="fa fa-th-large"></i> Dashboard
                        </a>
                        <a href="world.php" class="nav-link active">
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
                <div class="main-layout">
                    <div class="col-md-9 posts-feed">
                        <?php foreach ($posts as $post): ?>
                            <div class="post-card">
                                <div class="post-header-buttons">
                                    <div class="post-header">
                                        <div class="user-chip-avatar"><?php echo strtoupper(substr($post['username'], 0, 1)); ?></div>
                                        <div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($post['username']); ?></div>
                                            <div class="text-muted small"><?php echo date("M j, g:i A", strtotime($post['created_at'])); ?></div>
                                        </div>
                                    </div>

                                    <?php if ($post['user_id'] == $userId): ?>
                                    <form action="delete_post.php" method="POST">
                                        <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($post['content'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($post['image_path'])): ?>
                                    <img src="<?php echo htmlspecialchars($post['image_path']); ?>" class="post-image">
                                <?php endif; ?>

                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="col-md-3 suggested-panel">
                        <div class="card p-3">
                            <h6 class="mb-3">Suggested People</h6>
                            <?php foreach ($suggestedUsers as $user): ?>
                                <div class="suggested-user">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="user-chip-avatar"><?php echo strtoupper(substr($user['username'], 0, 1)); ?></div>
                                        <div class="fw-bold small"><?php echo htmlspecialchars($user['username']); ?></div>
                                    </div>
                                    <button class="btn btn-outline-success btn-sm" disabled title="Coming soon">Follow</button>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button type="button" class="btn btn-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#addPostModal">
                            <i class="fa fa-plus me-1"></i> Add Post
                        </button>
                    </div>
                </div>
            </main>
        </div>

        <div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="create_post.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addPostModalLabel">Create Post</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <textarea name="content" class="form-control mb-3" rows="4" placeholder="What's on your mind?"></textarea>
                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>