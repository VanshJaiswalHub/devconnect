<?php

    require_once __DIR__ . '/includes/current_user.php';
    require __DIR__ . '/includes/csrf.php';

    $postsPerPage = 10;

    // Get the requested page number from the URL.
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

    // Prevent page numbers below 1.
    $page = max(1, $page);


    // Count only the current user's posts.
    $countSql = "SELECT COUNT(*) AS total
                FROM posts
                WHERE user_id = ?";

    $countStmt = $conn->prepare($countSql);
    $countStmt->bind_param("i", $userId);
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


    // Fetch only the current user's posts.
    $sql = "SELECT
                posts.id,
                posts.user_id,
                posts.content,
                posts.image_path,
                posts.created_at,
                users.username,
                users.developer_role
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.user_id = ?
            ORDER BY posts.created_at DESC
            LIMIT ? OFFSET ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $userId, $postsPerPage, $offset);
    $stmt->execute();

    $posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    $conn->close();

    ?>

    <!DOCTYPE html>
    <html lang="en">

        <head>

            <meta charset="UTF-8">

            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <title>DevConnect - My Posts</title>

            <link
                href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
                rel="stylesheet"
            >

            <link
                rel="stylesheet"
                href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
            >

            <link rel="stylesheet" href="assets/style.css">

            <link rel="icon" href="assets/images/favicon.ico">

            <script src="assets/script.js" defer></script>

        </head>

        <body>

            <?php include __DIR__ . '/components/topbar.php'; ?>

            <?php include __DIR__ . '/components/sidebar.php'; ?>


            <main>

                <div class="main-layout">

                    <div class="col-md-9 posts-feed">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h3 class="mb-0">My Posts</h3>

                            <span class="text-muted small">
                                <?php echo $totalPosts; ?>
                                <?php echo $totalPosts == 1 ? 'post' : 'posts'; ?>
                            </span>

                        </div>


                        <?php if (empty($posts)): ?>

                            <div class="card p-4 text-center">

                                <i class="fa fa-file-text-o fa-2x text-muted mb-3"></i>

                                <h5>You haven't created any posts yet.</h5>

                                <p class="text-muted mb-3">
                                    Share something with the DevConnect community.
                                </p>

                                <button
                                    type="button"
                                    class="btn btn-success mx-auto"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addPostModal"
                                >
                                    <i class="fa fa-plus me-1"></i>
                                    Create Your First Post
                                </button>

                            </div>

                        <?php else: ?>

                            <?php foreach ($posts as $post): ?>

                                <div class="post-card">

                                    <div class="post-header-buttons">

                                        <div class="post-header">

                                            <div class="user-chip-avatar">
                                                <?php echo strtoupper(substr($post['username'], 0, 1)); ?>
                                            </div>

                                            <div>

                                                <div class="fw-bold">
                                                    <?php echo htmlspecialchars($post['username']); ?>
                                                </div>

                                                <div class="text-muted small">
                                                    <?php echo htmlspecialchars($post['developer_role']); ?>
                                                </div>

                                            </div>

                                        </div>


                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deletePostModal"
                                            data-post-id="<?php echo (int) $post['id']; ?>"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </div>


                                    <?php if (!empty($post['content'])): ?>

                                        <p>
                                            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
                                        </p>

                                    <?php endif; ?>


                                    <?php if (!empty($post['image_path'])): ?>

                                        <img
                                            src="<?php echo htmlspecialchars($post['image_path']); ?>"
                                            class="post-image"
                                            alt="Post image"
                                        >

                                    <?php endif; ?>

                                </div>

                            <?php endforeach; ?>


                            <?php if ($totalPages > 1): ?>

                                <div class="pagination">

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

                                </div>

                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                </div>

            </main>


            <!-- Add Post Modal -->

            <div
                class="modal fade"
                id="addPostModal"
                tabindex="-1"
                aria-labelledby="addPostModalLabel"
                aria-hidden="true"
            >

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form
                            action="create_post.php"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            <div class="modal-header">

                                <h5 class="modal-title" id="addPostModalLabel">
                                    Create Post
                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>

                            </div>


                            <div class="modal-body">

                                <textarea
                                    name="content"
                                    class="form-control mb-3"
                                    rows="4"
                                    placeholder="What's on your mind?"
                                ></textarea>

                                <input
                                    type="file"
                                    name="image"
                                    accept="image/*"
                                    class="form-control"
                                >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?php echo htmlspecialchars(generateCsrfToken()); ?>"
                                >

                            </div>


                            <div class="modal-footer">

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-success"
                                >
                                    Post
                                </button>

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
                                <strong>Delete This Post</strong>
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