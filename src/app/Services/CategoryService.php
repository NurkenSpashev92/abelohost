<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\PostSortEnum;
use App\Exceptions\NotFoundException;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;

final readonly class CategoryService
{
    private const PER_PAGE = 6;

    public function __construct(
        private CategoryRepository $categories,
        private PostRepository $posts,
    ) {
    }

    /**
     * @throws NotFoundException
     */
    public function getCategoryPage(int $categoryId, PostSortEnum $sort, int $page): array
    {
        $category = $this->categories->find($categoryId);

        if ($category === null) {
            throw new NotFoundException();
        }

        $total = $this->posts->countByCategory($categoryId);
        $pages = max(1, (int)ceil($total / self::PER_PAGE));

        if ($page > $pages) {
            throw new NotFoundException();
        }

        return [
            'category' => $category,
            'posts' => $this->posts->findByCategory(
                $categoryId,
                $sort,
                self::PER_PAGE,
                ($page - 1) * self::PER_PAGE
            ),
            'page' => $page,
            'pages' => $pages,
        ];
    }
}
