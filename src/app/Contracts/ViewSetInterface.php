<?php

declare(strict_types=1);

namespace App\Contracts;

interface ViewSetInterface
{
    public function render(string $view, array $data = []): string;
}
