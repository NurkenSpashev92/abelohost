<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Factories\CategoryFactory;
use App\Models\Category;
use PDO;

final readonly class CategoryRepository
{
    public function __construct(
        private PDO $pdo,
        private CategoryFactory $factory,
    ) {
    }

    /**
     * @return Category[]
     */
    public function findWithPosts(): array
    {
        $rows = $this->pdo->query(
            'SELECT DISTINCT
                c.id,
                c.name,
                c.description
             FROM categories c
             INNER JOIN category_post cp ON cp.category_id = c.id
             ORDER BY c.name'
        )->fetchAll();

        return $this->factory->makeMany($rows);
    }

    public function find(int $id): ?Category
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ? $this->factory->make($row) : null;
    }

    /**
     * @return Category[]
     */
    public function findByPost(int $postId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.id, c.name
             FROM categories c
             INNER JOIN category_post cp ON cp.category_id = c.id
             WHERE cp.post_id = :post_id
             ORDER BY c.name'
        );
        $stmt->execute(['post_id' => $postId]);

        return $this->factory->makeMany($stmt->fetchAll());
    }
}
