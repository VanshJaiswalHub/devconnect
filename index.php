<?php

require_once __DIR__ . '/includes/connection.php';

// Fetch a few recent public posts for the landing page.
$sql = "SELECT
            posts.content,
            posts.image_path,
            posts.created_at,
            users.username,
            users.developer_role
        FROM posts
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC
        LIMIT 3";

$stmt = $conn->prepare($sql);
$stmt->execute();

$recentPosts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt->close();


// Get some basic community statistics.
$sql = "SELECT COUNT(*) AS total FROM users";

$stmt = $conn->prepare($sql);
$stmt->execute();

$userCount = $stmt->get_result()->fetch_assoc()['total'];

$userCountDisplay = floor($userCount / 5) * 5;

$stmt->close();


$sql = "SELECT COUNT(*) AS total FROM posts";

$stmt = $conn->prepare($sql);
$stmt->execute();

$postCount = $stmt->get_result()->fetch_assoc()['total'];

$postCountDisplay = floor($postCount / 5) * 5;

$stmt->close();


function approximateCount($count)
{
    if ($count < 5) {
        return $count;
    }

    return floor($count / 5) * 5;
}

$userCountDisplay = approximateCount($userCount);
$postCountDisplay = approximateCount($postCount);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="DevConnect is a developer community where developers can share knowledge, discover other developers and build their professional presence."
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    >

    <link
        rel="stylesheet"
        href="assets/style.css"
    >

    <link
        rel="icon"
        href="assets/images/favicon.ico"
    >

    <title>DevConnect - Connect. Build. Grow.</title>

</head>

<body class="landing-page">

    <!-- Navigation -->

    <nav class="landing-nav">

        <div class="landing-container">

            <a href="index.php" class="landing-logo">

                <img
                    src="assets/images/logo.png"
                    alt="DevConnect"
                >

                <span>DevConnect</span>

            </a>


            <div class="landing-nav-links">

                <a href="#community">Community</a>

                <a href="#features">Features</a>

                <a href="authentication_form.php#loginbox" class="nav-login">
                    Login
                </a>

                <a href="authentication_form.php#registerbox" class="nav-register">
                    Join DevConnect
                </a>

            </div>

        </div>

    </nav>


    <!-- Hero -->

    <section class="landing-hero">

        <div class="landing-container">

            <div class="hero-content">

                <span class="hero-label">
                    <i class="fa fa-code"></i>
                    Built for developers
                </span>


                <h1>
                    Connect with developers.
                    <span>Build your presence.</span>
                </h1>


                <p class="hero-description">
                    DevConnect is a developer community where you can
                    share what you're building, discover other developers,
                    and grow your professional presence.
                </p>


                <div class="hero-actions">

                    <a
                        href="authentication_form.php#registerbox"
                        class="btn btn-dark btn-lg"
                    >
                        Join DevConnect
                        <i class="fa fa-arrow-right"></i>
                    </a>


                    <a
                        href="#community"
                        class="btn btn-outline-dark btn-lg"
                    >
                        Explore Community
                    </a>

                </div>


                <div class="hero-trust">

                    <span>
                        <i class="fa fa-users hero-trust-icon"></i>
                        <?php echo (int) $userCountDisplay; ?>+ developers
                    </span>

                    <span>
                        <i class="fa fa-comments hero-trust-icon"></i>
                        <?php echo (int) $postCountDisplay; ?>+ posts shared already
                    </span>

                    <span>
                        <i class="fa fa-shield"></i>
                        Secure accounts
                    </span>

                </div>

            </div>


            <!-- Hero visual -->

            <div class="hero-visual">

                <div class="code-window">

                    <div class="code-window-header">

                        <span></span>
                        <span></span>
                        <span></span>

                    </div>


                    <div class="code-content">

                        <div>
                            <span class="code-keyword">developer</span>
                            <span class="code-variable">=</span>
                            <span class="code-function">DevConnect</span>();
                        </div>

                        <div class="code-line">
                            &nbsp;
                        </div>

                        <div>
                            <span class="code-keyword">share</span>(
                            <span class="code-string">"knowledge"</span>
                            );
                        </div>

                        <div>
                            <span class="code-keyword">connect</span>(
                            <span class="code-string">"developers"</span>
                            );
                        </div>

                        <div>
                            <span class="code-keyword">build</span>(
                            <span class="code-string">"projects"</span>
                            );
                        </div>

                        <div>
                            <span class="code-keyword">grow</span>(
                            <span class="code-string">"together"</span>
                            );
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Features -->

    <section
        class="landing-section"
        id="features"
    >

        <div class="landing-container">

            <div class="section-heading">

                <span>WHY DEVCONNECT?</span>

                <h2>
                    More than just another developer profile.
                </h2>

                <p>
                    A simple place to share your work, discover developers,
                    and build your professional presence.
                </p>

            </div>


            <div class="row g-4">

                <div class="col-md-4">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="fa fa-pencil"></i>
                        </div>

                        <h3>Share What You Build</h3>

                        <p>
                            Publish posts about your projects,
                            development experience, ideas, and
                            things you've learned.
                        </p>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="fa fa-users"></i>
                        </div>

                        <h3>Discover Developers</h3>

                        <p>
                            Explore posts from developers with
                            different roles, experience levels,
                            and technical interests.
                        </p>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="feature-card">

                        <div class="feature-icon">
                            <i class="fa fa-user hero-trust-icon"></i>
                        </div>

                        <h3>Build Your Profile</h3>

                        <p>
                            Create a developer identity with your
                            role, experience, posts, followers,
                            and community activity.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- Recent Community Posts -->

    <section
        class="landing-section community-section"
        id="community"
    >

        <div class="landing-container">

            <div class="section-heading">

                <span>FROM THE COMMUNITY</span>

                <h2>
                    See what developers are sharing.
                </h2>

                <p>
                    A glimpse of the conversations happening on DevConnect.
                </p>

            </div>


            <div class="row g-4">

                <?php if (empty($recentPosts)): ?>

                    <div class="col-12">

                        <div class="empty-community">

                            <i class="fa fa-comments"></i>

                            <h3>The community is just getting started.</h3>

                            <p>
                                Be one of the first developers to share something.
                            </p>

                            <a
                                href="authentication_form.php#registerbox"
                                class="btn btn-dark"
                            >
                                Create Account
                            </a>

                        </div>

                    </div>

                <?php else: ?>

                    <?php foreach ($recentPosts as $post): ?>

                        <div class="col-md-4">

                            <article class="public-post-card">

                                <div class="post-author">

                                    <div class="post-avatar">
                                        <?php
                                        echo strtoupper(
                                            substr($post['username'], 0, 1)
                                        );
                                        ?>
                                    </div>

                                    <div>

                                        <strong>
                                            <?php
                                            echo htmlspecialchars(
                                                $post['username']
                                            );
                                            ?>
                                        </strong>

                                        <div class="text-muted small">
                                            <?php
                                            echo htmlspecialchars(
                                                $post['developer_role']
                                            );
                                            ?>
                                        </div>

                                    </div>

                                </div>


                                <?php if (!empty($post['content'])): ?>

                                    <p class="post-preview">
                                        <?php
                                        echo htmlspecialchars(
                                            $post['content']
                                        );
                                        ?>
                                    </p>

                                <?php endif; ?>


                                <?php if (!empty($post['image_path'])): ?>

                                    <img
                                        src="<?php echo htmlspecialchars($post['image_path']); ?>"
                                        alt="Developer post image"
                                        class="post-preview-image"
                                    >

                                <?php endif; ?>


                                <div class="post-footer">

                                    <span>
                                        <?php
                                        echo date(
                                            'M d, Y',
                                            strtotime($post['created_at'])
                                        );
                                        ?>
                                    </span>

                                    <span>
                                        <i class="fa fa-code"></i>
                                        Developer post
                                    </span>

                                </div>

                            </article>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>


            <?php if (!empty($recentPosts)): ?>

                <div class="text-center mt-5">

                    <a
                        href="authentication_form.php#registerbox"
                        class="btn btn-outline-dark"
                    >
                        Join to explore more
                        <i class="fa fa-arrow-right"></i>
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </section>


    <!-- CTA -->

    <section class="landing-cta">

        <div class="landing-container">

            <div>

                <span>READY TO BUILD YOUR PRESENCE?</span>

                <h2>
                    Your next connection could start with a post.
                </h2>

                <p>
                    Create your developer profile and start sharing.
                </p>

            </div>


            <a
                href="authentication_form.php#registerbox"
                class="btn btn-lg landing-primary-btn"
            >
                Create your account
                <i class="fa fa-arrow-right"></i>
            </a>

        </div>

    </section>


    <!-- Footer -->

    <footer class="landing-footer">

        <div class="landing-container">

            <div class="landing-logo">

                <img
                    src="assets/images/logo.png"
                    alt="DevConnect"
                >

                <span>DevConnect</span>

            </div>

            <p>
                A developer community built with PHP, MySQL and Bootstrap.
            </p>

            <span>
                © <?php echo date('Y'); ?> DevConnect
            </span>

        </div>

    </footer>


</body>

</html>