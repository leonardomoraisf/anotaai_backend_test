<?php

namespace App\Services;

use App\DTO\Api\V1\Products\StoreProductDto;
use App\DTO\Api\V1\Products\UpdateProductDto;
use App\Models\Product;
use App\Services\Aws\Sqs\Catalog\CatalogSqsService;

class ProductsService
{
    public function __construct(
        private readonly CatalogSqsService $catalogSqsService
    )
    {

    }

    public function getAll(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Product::where('user_id', auth()->id())->paginate(10);
    }

    public function getById($id): Product
    {
        $product = Product::where('user_id', auth()->id())->find($id);

        if (! $product) {
            throw new \RuntimeException('Product not found', 404);
        }

        return $product;
    }

    /**
     * @throws \JsonException
     */
    public function store(StoreProductDto $dto): Product
    {
        $product = Product::create([
            $dto->title,
            $dto->description,
            $dto->price,
            $dto->category_id,
        ]);

        $this->catalogSqsService->sendCatalogEmitProductMessage($product);

        return $product;
    }

    /**
     * @throws \JsonException
     */
    public function update($id, UpdateProductDto $dto): Product
    {
        $product = Product::where('user_id', auth()->id())->find($id);

        if (! $product) {
            throw new \RuntimeException('Product not found', 404);
        }

        $product->title = $dto->title ?? $product->title;
        $product->price = $dto->price ?? $product->price;
        $product->description = $dto->description ?? $product->description;
        $product->category_id = $dto->category_id ?? $product->category_id;
        $product->save();

        $this->catalogSqsService->sendCatalogEmitProductMessage($product);

        return $product;
    }

    /**
     * @throws \JsonException
     */
    public function delete($id): Product
    {
        $product = Product::where('user_id', auth()->id())->find($id);

        if (! $product) {
            throw new \RuntimeException('Product not found', 404);
        }

        $product->delete();

        $this->catalogSqsService->sendCatalogEmitProductMessage($product);

        return $product;
    }
}
