<?php

declare(strict_types=1);

use App\Exceptions\NotFoundException;
use App\Views\BaseViewSet;
use FastRoute\Dispatcher;

require __DIR__ . '/../vendor/autoload.php';

$dispatcher = require __DIR__ . '/../app/router.php';

$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$routeInfo = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], $uri);

function renderError(int $code, string $message): void
{
    http_response_code($code);
    echo (new BaseViewSet())->render('errors/error.tpl', [
        'title' => $code,
        'code' => $code,
        'message' => $message,
    ]);
}

try {
    switch ($routeInfo[0]) {
        case Dispatcher::NOT_FOUND:
            throw new NotFoundException();

        case Dispatcher::METHOD_NOT_ALLOWED:
            header('Allow: ' . implode(', ', $routeInfo[1]));
            renderError(405, 'Метод не поддерживается');
            break;

        case Dispatcher::FOUND:
            [$class, $method] = $routeInfo[1];
            echo (new $class())->$method(...$routeInfo[2]);
            break;
    }
} catch (NotFoundException) {
    renderError(404, 'Страница не найдена');
} catch (Throwable $e) {
    error_log((string) $e);
    renderError(500, 'Внутренняя ошибка сервера');
}
