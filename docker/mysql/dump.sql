CREATE TABLE `categories`
(
    `id`          int unsigned NOT NULL AUTO_INCREMENT,
    `name`        varchar(255) NOT NULL,
    `description` text,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `posts`
(
    `id`           int unsigned NOT NULL AUTO_INCREMENT,
    `title`        varchar(255) NOT NULL,
    `description`  text,
    `content`      longtext     NOT NULL,
    `image`        varchar(255)          DEFAULT NULL,
    `views`        int unsigned NOT NULL DEFAULT 0,
    `published_at` datetime     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_posts_published_at` (`published_at`),
    KEY `idx_posts_views` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `category_post`
(
    `category_id` int unsigned NOT NULL,
    `post_id`     int unsigned NOT NULL,
    PRIMARY KEY (`category_id`, `post_id`),
    KEY `idx_category_post_post_id` (`post_id`),
    CONSTRAINT `fk_category_post_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_category_post_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
