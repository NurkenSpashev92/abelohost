<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

final readonly class BlogService
{
    public function __construct(
        private CategoryRepository $categories,
        private PostRepository $posts,
    ) {
    }

    public function getCategoriesWithLatestPosts(int $postsPerCategory = 3): array
    {
        $postsByCategory = $this->posts->findLatestPerCategory($postsPerCategory);

        $result = [];
        $categories = $this->categories->findWithPosts();
        foreach ($categories as $category) {
            $result[] = [
                'category' => $category,
                'posts' => $postsByCategory[$category->id] ?? [],
            ];
        }

        return $result;
    }
}
