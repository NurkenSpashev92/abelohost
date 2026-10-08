<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CategoryDto;
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
    public function getCategoryPage(CategoryDto $dto): array
    {
        $category = $this->categories->find($dto->id);

        if ($category === null) {
            throw new NotFoundException();
        }

        $total = $this->posts->countByCategory($dto->id);
        $pages = max(1, (int)ceil($total / self::PER_PAGE));

        if ($dto->page > $pages) {
            throw new NotFoundException();
        }

        return [
            'category' => $category,
            'posts' => $this->posts->findByCategory(
                $dto->id,
                $dto->sort,
                self::PER_PAGE,
                ($dto->page - 1) * self::PER_PAGE
            ),
            'page' => $dto->page,
            'pages' => $pages,
        ];
    }
}
