<?php

declare(strict_types=1);

namespace App\Factories;

use App\Models\Post;

final class PostFactory
{
    public function make(array $row): Post
    {
        return new Post(
            id: (int) $row['id'],
            title: $row['title'],
            description: $row['description'],
            image: $row['image'],
            views: (int) $row['views'],
            publishedAt: $row['published_at'],
            content: $row['content'] ?? null,
        );
    }

    /**
     * @return Post[]
     */
    public function makeMany(array $rows): array
    {
        $posts = [];
        foreach ($rows as $row) {
            $posts[] = $this->make($row);
        }

        return $posts;
    }
}
