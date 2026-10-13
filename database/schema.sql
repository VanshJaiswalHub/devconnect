CREATE DATABASE IF NOT EXISTS dev_connect;

USE dev_connect;


-- ============================================
-- Users
-- ============================================

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    developer_role VARCHAR(50) NOT NULL,
    experience_years TINYINT(3) UNSIGNED DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY username_unique (username),
    UNIQUE KEY email_unique (email)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;


-- ============================================
-- Posts
-- ============================================

CREATE TABLE posts (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT UNSIGNED NOT NULL,
    content TEXT DEFAULT NULL,
    image_path VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    KEY user_id (user_id),

    CONSTRAINT posts_ibfk_1
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;


-- ============================================
-- Follows
-- ============================================

CREATE TABLE follows (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    follower_id INT UNSIGNED NOT NULL,
    following_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id),
    UNIQUE KEY unique_follow (follower_id, following_id),
    KEY following_id (following_id),

    CONSTRAINT follows_ibfk_1
        FOREIGN KEY (follower_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    CONSTRAINT follows_ibfk_2
        FOREIGN KEY (following_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;