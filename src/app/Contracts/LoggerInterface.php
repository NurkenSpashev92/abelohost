<?php

declare(strict_types=1);

namespace App\Contracts;

use Stringable;

interface LoggerInterface
{
    public function error(string|Stringable $message, array $context = []): void;
}
