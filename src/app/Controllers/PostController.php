<?php

declare(strict_types=1);

namespace App\Controllers;

use App\DTO\PostDto;
use App\Services\PostService;
use Smarty\Exception;

final class PostController extends Controller
{
    public function __construct(private readonly PostService $postService)
    {
    }

    /**
     * @throws Exception
     */
    public function show(string $id): string
    {
        $data = $this->postService->getPostPage(new PostDto(id: (int) $id));

        return $this->render('post/show.tpl', [
            ...$data,
            'title' => $data['post']->title,
        ]);
    }
}
