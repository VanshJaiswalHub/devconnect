CREATE DATABASE IF NOT EXISTS dev_connect;

USE dev_connect;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY username_unique (username),
    UNIQUE KEY email_unique (email)
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT DEFAULT NULL,
    image_path VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX user_id (user_id),

    CONSTRAINT posts_ibfk_1
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);