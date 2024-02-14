<?php

namespace App\DTO\Api\V1\Products;

class StoreProductDto
{
    public function __construct(
        public readonly string $title,
        public readonly float $price,
        public readonly ?string $description,
        public readonly ?int $category_id,
    )
    {

    }
}
