<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use FastRoute\RouteCollector;

return FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
});
