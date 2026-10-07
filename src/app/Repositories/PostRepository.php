<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final readonly class PostRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findLatestPerCategory(int $limit): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT
                p.id,
                p.title,
                p.description,
                p.views,
                p.published_at,
                cp.category_id
             FROM posts p
             INNER JOIN category_post cp ON cp.post_id = p.id
             LEFT JOIN category_post newer_cp ON newer_cp.category_id = cp.category_id
             LEFT JOIN posts newer ON newer.id = newer_cp.post_id
                AND (newer.published_at > p.published_at OR (newer.published_at = p.published_at AND newer.id > p.id))
             GROUP BY p.id, cp.category_id
             HAVING COUNT(newer.id) < :limit
             ORDER BY p.published_at DESC'
        );
        $stmt->execute(['limit' => $limit]);

        return $stmt->fetchAll();
    }
}
