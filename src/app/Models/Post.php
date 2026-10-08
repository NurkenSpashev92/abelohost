<?php

declare(strict_types=1);

namespace App\Models;

final readonly class Post
{
    public function __construct(
        public int $id,
        public string $title,
        public ?string $description,
        public ?string $image,
        public int $views,
        public string $publishedAt,
        public ?string $content = null,
    ) {
    }
}
