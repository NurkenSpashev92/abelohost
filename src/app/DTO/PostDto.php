<?php

declare(strict_types=1);

namespace App\DTO;

final readonly class PostDto
{
    public function __construct(
        public int $id,
    ) {
    }
}
