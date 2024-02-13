<?php

namespace App\Services;

use App\Models\Product;
use App\Services\Aws\AwsSqsService;

class ProductsService
{
    private AwsSqsService $awsSqsService;

    public function __construct(AwsSqsService $awsSqsService)
    {
        $this->awsSqsService = $awsSqsService;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Product::query()
            ->where('user_id', auth()->id())
            ->get();
    }

    public function getById($id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $product = Product::query()
            ->where('user_id', auth()->id())
            ->find($id);

        if (! $product) {
            throw new \RuntimeException('Product not found', 404);
        }

        return $product;
    }

    public function create(array $data): Product
    {
        $product = new Product($data);
        $product->save();

        $this->sendMessage($product);

        return $product;
    }

    public function update($id, array $data): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $product = Product::query()
            ->where('user_id', auth()->id())
            ->find($id);

        if (! $product) {
            throw new \RuntimeException('Product not found', 404);
        }

        $product->fill($data);
        $product->save();

        $this->sendMessage($product);

        return $product;
    }

    public function delete($id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $product = Product::query()
            ->where('user_id', auth()->id())
            ->find($id);

        if (! $product) {
            throw new \RuntimeException('Product not found', 404);
        }

        $product->delete();

        $this->sendMessage($product);

        return $product;
    }

    /**
     * @throws \JsonException
     */
    private function sendMessage($product): void
    {
        $body = [
            'userId' => auth()->id(),
            'product' => $product,
            'type' => 'product',
        ];

        $this->awsSqsService->sendMessage('catalog-emit', json_encode($body, JSON_THROW_ON_ERROR));
    }
}
