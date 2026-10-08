<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enums\PostSortEnum;

final readonly class CategoryDto
{
    public function __construct(
        public int $id,
        public PostSortEnum $sort,
        public int $page,
    ) {
    }
}
