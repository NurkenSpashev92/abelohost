<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

final readonly class PostService
{
    private const SIMILAR_LIMIT = 3;

    public function __construct(
        private PostRepository $posts,
        private CategoryRepository $categories,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function getPostPage(int $id): array
    {
        $this->posts->incrementViews($id);

        $post = $this->posts->find($id);

        if ($post === null) {
            throw new NotFoundException();
        }

        return [
            'post' => $post,
            'categories' => $this->categories->findByPost($id),
            'similar' => $this->posts->findSimilar($id, self::SIMILAR_LIMIT),
        ];
    }
}
