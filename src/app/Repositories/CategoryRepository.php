<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final readonly class CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findWithPosts(): array
    {
        return $this->pdo->query(
            'SELECT DISTINCT
                c.id,
                c.name,
                c.description
             FROM categories c
             INNER JOIN category_post cp ON cp.category_id = c.id
             ORDER BY c.name'
        )->fetchAll();
    }
}
