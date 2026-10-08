<?php

declare(strict_types=1);

namespace App\Factories;

use App\Models\Category;

final class CategoryFactory
{
    public function make(array $row): Category
    {
        return new Category(
            id: (int) $row['id'],
            name: $row['name'],
            description: $row['description'] ?? null,
        );
    }

    /**
     * @return Category[]
     */
    public function makeMany(array $rows): array
    {
        $categorys = [];
        foreach ($rows as $row) {
            $categorys[] = $this->make($row);
        }

        return $categorys;
    }
}
