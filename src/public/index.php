<?php

declare(strict_types=1);

use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Core\Database\Mysql;
use App\Core\Logger\FileLogger;
use App\Exceptions\NotFoundException;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Services\BlogService;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Views\BaseViewSet;
use FastRoute\Dispatcher;

require __DIR__ . '/../vendor/autoload.php';

$dispatcher = require __DIR__ . '/../app/router.php';

$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$view = new BaseViewSet();

try {
    $route = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $uri);

    if ($route[0] !== Dispatcher::FOUND) {
        throw new NotFoundException();
    }

    $config = require __DIR__ . '/../app/Core/config.php';
    $pdo = Mysql::connect($config['mysql']);

    [$class, $method] = $route[1];

    $controller = match ($class) {
        HomeController::class => new HomeController(
            new BlogService(
                new CategoryRepository($pdo),
                new PostRepository($pdo)
            ),
        ),
        CategoryController::class => new CategoryController(
            new CategoryService(
                new CategoryRepository($pdo),
                new PostRepository($pdo)
            ),
        ),
        PostController::class => new PostController(
            new PostService(
                new PostRepository($pdo),
                new CategoryRepository($pdo)
            ),
        ),
    };

    echo $controller->$method(...$route[2]);
} catch (NotFoundException) {
    http_response_code(404);
    echo $view->render('errors/error.tpl', ['code' => 404, 'message' => 'Страница не найдена']);
} catch (Throwable $e) {
    (new FileLogger(__DIR__ . '/../tmp/logs/app.log'))->error($e->getMessage(), [
        'exception' => $e::class,
        'file' => $e->getFile() . ':' . $e->getLine(),
        'uri' => $uri,
    ]);

    http_response_code(500);
    echo $view->render('errors/error.tpl', ['code' => 500, 'message' => 'Внутренняя ошибка сервера']);
}
