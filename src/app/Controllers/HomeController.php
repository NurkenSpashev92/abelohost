<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\BlogService;
use Smarty\Exception;

final class HomeController extends Controller
{
    public function __construct(private readonly BlogService $blogService)
    {
    }

    /**
     * @throws Exception
     */
    public function index(): string
    {
        return $this->render('home/index.tpl', [
            'title' => 'Блог',
            'categories' => $this->blogService->getCategoriesWithLatestPosts(),
        ]);
    }
}
