<?php

namespace App\Services;

use App\DTO\Api\V1\Categories\StoreCategoryDto;
use App\DTO\Api\V1\Categories\UpdateCategoryDto;
use App\Models\Category;
use App\Services\Aws\Sqs\Catalog\CatalogSqsService;

class CategoriesService
{
    public function __construct(
        private readonly CatalogSqsService $catalogSqsService
    )
    {

    }

    public function getAll(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Category::where('user_id', auth()->id())->paginate(10);
    }

    public function getById($id): Category
    {
        $category = Category::where('user_id', auth()->id())->find($id);

        if (! $category) {
            throw new \RuntimeException('Category not found', 404);
        }

        return $category;
    }

    /**
     * @throws \JsonException
     */
    public function store(StoreCategoryDto $dto): Category
    {
        $category = Category::create([
            'title' => $dto->title,
            'description' => $dto->description,
        ]);

        $this->catalogSqsService->sendCatalogEmitCategoryMessage($category);

        return $category;
    }

    /**
     * @throws \JsonException
     */
    public function update($id, UpdateCategoryDto $dto): Category
    {
        $category = Category::where('user_id', auth()->id())->find($id);

        if (! $category) {
            throw new \RuntimeException('Category not found', 404);
        }

        $category->title = $dto->title ?? $category->title;
        $category->description = $dto->description ?? $category->description;
        $category->save();

        $this->catalogSqsService->sendCatalogEmitCategoryMessage($category);

        return $category;
    }

    /**
     * @throws \JsonException
     */
    public function delete($id): Category
    {
        $category = Category::where('user_id', auth()->id())->find($id);

        if (! $category) {
            throw new \RuntimeException('Category not found', 404);
        }

        $category->delete();

        $this->catalogSqsService->sendCatalogEmitCategoryMessage($category);

        return $category;
    }
}
