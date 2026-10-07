<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\PostSortEnum;
use PDO;

final readonly class PostRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findLatestPerCategory(int $limit): array
    {
        $stmt = $this->pdo->prepare(
            'WITH ranked AS (
                SELECT
                    p.id,
                    p.title,
                    p.description,
                    p.image,
                    p.views,
                    p.published_at,
                    cp.category_id,
                    ROW_NUMBER() OVER (
                        PARTITION BY cp.category_id
                        ORDER BY p.published_at DESC, p.id DESC
                    ) AS rn
                FROM posts p
                INNER JOIN category_post cp ON cp.post_id = p.id
             )
             SELECT id, title, description, image, views, published_at, category_id
             FROM ranked
             WHERE rn <= :limit
             ORDER BY published_at DESC'
        );
        $stmt->execute(['limit' => $limit]);

        return $stmt->fetchAll();
    }

    public function findByCategory(int $categoryId, PostSortEnum $sort, int $limit, int $offset): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT
                p.id,
                p.title,
                p.description,
                p.image,
                p.views,
                p.published_at
             FROM posts p
             INNER JOIN category_post cp ON cp.post_id = p.id
             WHERE cp.category_id = :category_id
             ORDER BY ' . $sort->column() . ' DESC, p.id DESC
             LIMIT :limit OFFSET :offset'
        );
        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM category_post WHERE category_id = :category_id');
        $stmt->execute(['category_id' => $categoryId]);

        return (int) $stmt->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, title, description, content, image, views, published_at
             FROM posts
             WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->pdo->prepare('UPDATE posts SET views = views + 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function findSimilar(int $postId, int $limit): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT
                p.id,
                p.title,
                p.description,
                p.image,
                p.views,
                p.published_at
             FROM category_post cp
             INNER JOIN category_post similar_cp
                ON similar_cp.category_id = cp.category_id
                AND similar_cp.post_id <> cp.post_id
             INNER JOIN posts p ON p.id = similar_cp.post_id
             WHERE cp.post_id = :post_id
             GROUP BY p.id
             ORDER BY COUNT(*) DESC, p.published_at DESC, p.id DESC
             LIMIT :limit'
        );
        $stmt->bindValue('post_id', $postId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
