<?php

use App\Controllers\HomeController;


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        echo (new HomeController())->index();
    });
});
