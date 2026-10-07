<?php

declare(strict_types=1);

use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use FastRoute\RouteCollector;

return FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('GET', '/category/{id:\d+}', [CategoryController::class, 'show']);
    $r->addRoute('GET', '/post/{id:\d+}', [PostController::class, 'show']);
});
