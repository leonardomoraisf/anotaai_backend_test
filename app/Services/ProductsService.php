<?php

namespace App\Services;

use App\Models\Product;

class ProductsService
{
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

        return $product;
    }
}
