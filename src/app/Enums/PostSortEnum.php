<?php

declare(strict_types=1);

namespace App\Enums;

enum PostSortEnum: string
{
    case Date = 'date';
    case Views = 'views';

    public function column(): string
    {
        return match ($this) {
            self::Date => 'p.published_at',
            self::Views => 'p.views',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Date => 'По дате',
            self::Views => 'По просмотрам',
        };
    }
}
