<?php

declare(strict_types=1);

use App\Controllers\CategoryController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Core\Database\Mysql;
use App\Core\Logger\FileLogger;
use App\Core\Views\BaseViewSet;
use App\Exceptions\NotFoundException;
use App\Factories\CategoryFactory;
use App\Factories\PostFactory;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Services\BlogService;
use App\Services\CategoryService;
use App\Services\PostService;
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

    $categoryRepository = new CategoryRepository($pdo, new CategoryFactory());
    $postRepository = new PostRepository($pdo, new PostFactory());

    [$class, $method] = $route[1];

    $controller = match ($class) {
        HomeController::class => new HomeController(
            new BlogService(
                $categoryRepository,
                $postRepository
            ),
        ),
        CategoryController::class => new CategoryController(
            new CategoryService(
                $categoryRepository,
                $postRepository
            ),
        ),
        PostController::class => new PostController(
            new PostService(
                $postRepository,
                $categoryRepository
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
