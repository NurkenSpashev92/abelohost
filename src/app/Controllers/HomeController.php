<?php

declare(strict_types=1);

namespace App\Controllers;

use Smarty\Exception;

final class HomeController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(): string
    {
        return $this->render('home/index.tpl', [
            'title' => 'Блог',
            'categories' => [],
        ]);
    }
}
