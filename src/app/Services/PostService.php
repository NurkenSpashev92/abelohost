<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PostDto;
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
    public function getPostPage(PostDto $dto): array
    {
        $post = $this->posts->find($dto->id);

        if ($post === null) {
            throw new NotFoundException();
        }
        $this->posts->incrementViews($dto->id);

        return [
            'post' => $post,
            'categories' => $this->categories->findByPost($dto->id),
            'similar' => $this->posts->findSimilar($dto->id, self::SIMILAR_LIMIT),
        ];
    }
}
