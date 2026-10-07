<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Views\BaseViewSet;

class Controller extends BaseViewSet
{
    public function index(): string
    {
        return "hello world";
    }
}