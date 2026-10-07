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
        $postsByCategory = [];
        foreach ($this->posts->findLatestPerCategory($postsPerCategory) as $post) {
            $postsByCategory[$post['category_id']][] = $post;
        }

        $categories = $this->categories->findWithPosts();
        foreach ($categories as &$category) {
            $category['posts'] = $postsByCategory[$category['id']] ?? [];
        }

        return $categories;
    }
}
