<?php

namespace App\DTO\Api\V1\Categories;

class StoreCategoryDto
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description
    )
    {

    }
}
