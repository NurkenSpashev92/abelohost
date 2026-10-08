<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DTO\CategoryDto;
use App\Enums\PostSortEnum;
use App\Services\CategoryService;
use Smarty\Exception;

final class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    /**
     * @throws Exception
     */
    public function show(string $id): string
    {
        $dto = new CategoryDto(
            id: (int) $id,
            sort: PostSortEnum::tryFrom($_GET['sort'] ?? '') ?? PostSortEnum::Date,
            page: max(1, (int) ($_GET['page'] ?? 1)),
        );

        $data = $this->categoryService->getCategoryPage($dto);

        return $this->render('category/show.tpl', [
            ...$data,
            'title' => $data['category']->name,
            'sort' => $dto->sort,
            'sorts' => PostSortEnum::cases(),
        ]);
    }
}
