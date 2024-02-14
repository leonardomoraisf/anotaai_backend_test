<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\Api\V1\Products\StoreProductDto;
use App\DTO\Api\V1\Products\UpdateProductDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Products\StoreRequest;
use App\Http\Requests\Api\V1\Products\UpdateRequest;
use App\Http\Resources\Api\V1\ProductResource;
use App\Services\ProductsService;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    /**
     * Create a new ProductsController instance.
     *
     * @return void
     */
    public function __construct(
        private readonly ProductsService $productsService
    )
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        try {
            $products = $this->productsService->getAll();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return ProductResource::collection($products)->response(request());
    }

    public function show($id): JsonResponse
    {
        try {
            $product = $this->productsService->getById($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return ProductResource::make($product)->response(request());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        try {
            $product = $this->productsService->store(
                new StoreProductDto(
                    $request->validated('title'),
                    $request->validated('price'),
                    $request->validated('description'),
                    $request->validated('category_id'),
                )
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($product);
    }

    public function update(UpdateRequest $request, $id): JsonResponse
    {
        try {
            $product = $this->productsService->update(
                $id,
                new UpdateProductDto(
                    $request->validated('title'),
                    $request->validated('price'),
                    $request->validated('description'),
                    $request->validated('category_id'),
                )
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($product);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->productsService->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json(null, 204);
    }
}
