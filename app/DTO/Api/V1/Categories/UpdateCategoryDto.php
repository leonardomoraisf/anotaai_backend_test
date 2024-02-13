<?php

namespace App\DTO\Api\V1\Categories;

class UpdateCategoryDto
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description
    )
    {

    }
}
