<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Api\V1\Categories\StoreCategoryDto;
use App\DTO\Api\V1\Categories\UpdateCategoryDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Categories\StoreRequest;
use App\Http\Requests\Api\V1\Categories\UpdateRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Services\CategoriesService;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller
{
    /**
     * Create a new ProductsController instance.
     *
     * @return void
     */
    public function __construct(
        private readonly CategoriesService $categoriesService
    )
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        try {
            $categories = $this->categoriesService->getAll();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return CategoryResource::collection($categories)->response(request());
    }

    public function show($id): JsonResponse
    {
        try {
            $category = $this->categoriesService->getById($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return CategoryResource::make($category)->response(request());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $category = $this->categoriesService->store(
                new StoreCategoryDto(
                    title: $request->validated('title'),
                    description: $request->validated('description')
                )
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return CategoryResource::make($category)->response($request);
    }

    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $category = $this->categoriesService->update(
                $id,
                new UpdateCategoryDto(
                    title: $request->validated('title'),
                    description: $request->validated('description')
                )
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return CategoryResource::make($category)->response($request);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->categoriesService->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json(null, 204);
    }
}
