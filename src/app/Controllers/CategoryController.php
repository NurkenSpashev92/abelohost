<?php

declare(strict_types=1);

namespace App\Controllers;

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
        $sort = PostSortEnum::tryFrom($_GET['sort'] ?? '') ?? PostSortEnum::Date;
        $page = max(1, (int) ($_GET['page'] ?? 1));

        $data = $this->categoryService->getCategoryPage((int) $id, $sort, $page);

        return $this->render('category/show.tpl', [
            ...$data,
            'title' => $data['category']['name'],
            'sort' => $sort,
            'sorts' => PostSortEnum::cases(),
        ]);
    }
}
