<?php

declare(strict_types=1);

use App\Core\Database\Mysql;
use App\Seeders\BlogSeeder;
use Faker\Factory;

require __DIR__ . '/../vendor/autoload.php';

$postsCount = max(1, (int) ($argv[1] ?? 40));

$config = require __DIR__ . '/../app/Core/config.php';

try {
    (new BlogSeeder(
        Mysql::connect($config['mysql']),
        Factory::create('ru_RU')
    ))->run($postsCount);
} catch (Throwable $e) {
    echo "Ошибка запуска seeder ❌🆘‼️" . PHP_EOL;
}

echo "Готово ❇️: добавлено статей — {$postsCount} ✅" . PHP_EOL;
