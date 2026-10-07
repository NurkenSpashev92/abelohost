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
            'WITH ranked AS (
                SELECT
                    p.id,
                    p.title,
                    p.description,
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
             SELECT id, title, description, views, published_at, category_id
             FROM ranked
             WHERE rn <= :limit
             ORDER BY published_at DESC'
        );
        $stmt->execute(['limit' => $limit]);

        return $stmt->fetchAll();
    }
}
