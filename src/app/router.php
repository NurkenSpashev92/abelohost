<?php

use App\Controllers\Controller;


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', function () {
        echo (new Controller())->index();
    });
});
