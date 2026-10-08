<?php

declare(strict_types=1);

namespace App\Seeders;

use Faker\Generator;
use PDO;
use Throwable;

final readonly class BlogSeeder
{
    private const CATEGORIES_COUNT = 6;
    private const IMAGE_URL = 'https://picsum.photos/seed/%d/800/450';

    public function __construct(
        private PDO $pdo,
        private Generator $faker,
    ) {
    }

    public function run(int $postsCount): void
    {
        $this->truncate();

        $this->pdo->beginTransaction();

        try {
            $categoryIds = $this->seedCategories();
            $this->seedPosts($postsCount, $categoryIds);

            $this->pdo->commit();
        } catch (Throwable $e) {
            $this->pdo->rollBack();

            throw $e;
        }
    }

    private function truncate(): void
    {
        $this->pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
        $this->pdo->exec('TRUNCATE TABLE category_post');
        $this->pdo->exec('TRUNCATE TABLE posts');
        $this->pdo->exec('TRUNCATE TABLE categories');
        $this->pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    }

    private function seedCategories(): array
    {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name, description) VALUES (:name, :description)');

        $ids = [];
        for ($i = 0; $i < self::CATEGORIES_COUNT; $i++) {
            $stmt->execute([
                'name' => $this->phrase(20),
                'description' => $this->faker->realText(120),
            ]);
            $ids[] = (int) $this->pdo->lastInsertId();
        }

        return $ids;
    }

    private function seedPosts(int $count, array $categoryIds): void
    {
        $insertPost = $this->pdo->prepare(
            'INSERT INTO posts (title, description, content, image, views, published_at)
             VALUES (:title, :description, :content, :image, :views, :published_at)'
        );
        $attachCategory = $this->pdo->prepare(
            'INSERT INTO category_post (category_id, post_id) VALUES (:category_id, :post_id)'
        );

        for ($i = 0; $i < $count; $i++) {
            $insertPost->execute([
                'title' => $this->phrase(50),
                'description' => $this->faker->realText(150),
                'content' => $this->content(),
                'image' => $this->image(),
                'views' => $this->faker->numberBetween(0, 1000),
                'published_at' => $this->faker->dateTimeBetween('-1 year')->format('Y-m-d H:i:s'),
            ]);
            $postId = (int) $this->pdo->lastInsertId();

            $postCategories = $this->faker->randomElements($categoryIds, $this->faker->numberBetween(1, 3));
            foreach ($postCategories as $categoryId) {
                $attachCategory->execute(['category_id' => $categoryId, 'post_id' => $postId]);
            }
        }
    }

    private function image(): string
    {
        return sprintf(self::IMAGE_URL, $this->faker->unique()->numberBetween(1, 100000));
    }

    private function phrase(int $maxLength): string
    {
        return rtrim($this->faker->realText($maxLength), '.');
    }

    private function content(): string
    {
        $paragraphs = [];
        $count = $this->faker->numberBetween(5, 8);
        for ($i = 0; $i < $count; $i++) {
            $paragraphs[] = $this->faker->realText($this->faker->numberBetween(300, 600));
        }

        return implode("\n\n", $paragraphs);
    }
}
