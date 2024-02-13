<?php

namespace App\Services;

use App\Models\Category;

class CategoriesService
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Category::query()
            ->where('user_id', auth()->id())
            ->get();
    }

    public function getById($id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $category = Category::query()
            ->where('user_id', auth()->id())
            ->find($id);

        if (! $category) {
            throw new \RuntimeException('Category not found', 404);
        }

        return $category;
    }

    public function create(array $data): Category
    {
        $category = new Category($data);
        $category->save();

        return $category;
    }

    public function update($id, array $data): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $category = Category::query()
            ->where('user_id', auth()->id())
            ->find($id);

        if (! $category) {
            throw new \RuntimeException('Category not found', 404);
        }

        $category->fill($data);
        $category->save();

        return $category;
    }

    public function delete($id): \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
    {
        $category = Category::query()
            ->where('user_id', auth()->id())
            ->find($id);

        if (! $category) {
            throw new \RuntimeException('Category not found', 404);
        }

        $category->delete();

        return $category;
    }
}
