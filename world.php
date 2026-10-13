<?php
require_once __DIR__ . '/includes/current_user.php';
require __DIR__ . '/includes/csrf.php';

$postsPerPage = 10;

// Get the requested page number from the URL.
// If no page is provided, start at page 1.
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

// Prevent page numbers below 1.
$page = max(1, $page);


// Count the total number of posts.
$countSql = "SELECT COUNT(*) AS total FROM posts";
$countStmt = $conn->prepare($countSql);
$countStmt->execute();

$countResult = $countStmt->get_result();
$totalPosts = $countResult->fetch_assoc()['total'];

$countStmt->close();


// Calculate how many pages are required.
$totalPages = (int) ceil($totalPosts / $postsPerPage);


// If someone requests a page beyond the last page,
// use the last available page instead.
if ($totalPages > 0) {
    $page = min($page, $totalPages);
}


// Calculate how many posts should be skipped.
$offset = ($page - 1) * $postsPerPage;


// Fetch the posts for the current page.
$sql = "SELECT
            posts.id,
            posts.user_id,
            posts.content,
            posts.image_path,
            posts.created_at,
            users.username,
            users.developer_role,
            follows.id AS follow_id
        FROM posts
        JOIN users ON posts.user_id = users.id
        LEFT JOIN follows
            ON follows.following_id = posts.user_id
            AND follows.follower_id = ?
        ORDER BY posts.created_at DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $userId, $postsPerPage, $offset);
$stmt->execute();

$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close();

// Suggested people to follow (no real "follow" system yet — display only)
$sql = "SELECT
                users.id,
                users.username,
                follows.id AS follow_id
            FROM users
            LEFT JOIN follows
                ON follows.following_id = users.id
                AND follows.follower_id = ?
            WHERE users.id != ?
            ORDER BY RAND()
            LIMIT 5";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $userId, $userId);
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
        <link rel="icon" type="image/svg+xml" href="assets/images/favicon.ico">
        <script src="assets/script.js" defer></script>
    </head>

    <!-- Body Section -->

    <body>

        <!-- Topbar Section -->
        <?php include __DIR__ . '/components/topbar.php';?>

        <!-- Sidebar -->
        <?php include __DIR__ . '/components/sidebar.php'; ?>

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
                                        <div class="text-muted small"><?php echo htmlspecialchars($post['developer_role']); ?></div>
                                    </div>
                                </div>

                                <?php if ($post['user_id'] == $userId): ?>
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deletePostModal"
                                    data-post-id="<?php echo (int) $post['id']; ?>"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                                <?php endif; ?>
                                <?php if ($post['user_id'] != $userId): ?>
                                    <button
                                        type="button"
                                        class="follow-btn btn btn-outline-success"
                                        data-user-id="<?php echo (int) $post['user_id']; ?>"
                                        data-csrf-token="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
                                        <?php echo $post['follow_id'] !== null ? 'Following' : 'Follow'; ?>
                                    </button>
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

                    <div class="pagination">

                        <?php if ($totalPages > 1): ?>

                            <nav aria-label="Post pagination">

                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo $page - 1; ?>">
                                        &laquo; Previous
                                    </a>
                                <?php endif; ?>


                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                                    <?php if ($i == $page): ?>

                                        <strong>
                                            <?php echo $i; ?>
                                        </strong>

                                    <?php else: ?>

                                        <a href="?page=<?php echo $i; ?>">
                                            <?php echo $i; ?>
                                        </a>

                                    <?php endif; ?>

                                <?php endfor; ?>


                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?php echo $page + 1; ?>">
                                        Next &raquo;
                                    </a>
                                <?php endif; ?>

                            </nav>
                        <?php endif; ?>
                    </div>
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
                                <button
                                    type="button"
                                    class="follow-btn btn btn-outline-success btn-sm"
                                    data-user-id="<?php echo (int) $user['id']; ?>"
                                    data-csrf-token="<?php echo htmlspecialchars(generateCsrfToken()); ?>"
                                >
                                    <?php echo $user['follow_id'] !== null ? 'Following' : 'Follow'; ?>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" class="btn btn-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#addPostModal">
                        <i class="fa fa-plus me-1"></i> Add Post
                    </button>
                </div>
            </div>
        </main>

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
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(generateCsrfToken()); ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="deletePostModal"
            tabindex="-1"
            aria-labelledby="deletePostModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="deletePostModalLabel">
                            Delete Post
                        </h5>

                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>

                    </div>

                    <div class="modal-body">

                        Are you sure you want to delete this post?

                        <div class="text-muted small mt-2">
                            This action cannot be undone.
                        </div>

                    </div>

                    <div class="modal-footer">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>

                        <form action="delete_post.php" method="POST" id="deletePostForm">

                            <input
                                type="hidden"
                                name="post_id"
                                id="deletePostId"
                            >

                            <input
                                type="hidden"
                                name="csrf_token"
                                value="<?php echo htmlspecialchars(generateCsrfToken()); ?>"
                            >

                            <button type="submit" class="btn btn-danger">
                                Delete Post
                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>