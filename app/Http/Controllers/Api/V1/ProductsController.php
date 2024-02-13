<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProductsService;
use Illuminate\Http\Request;

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

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $products = $this->productsService->getAll();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($products);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $product = $this->productsService->getById($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($product);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        try {
            $product = $this->productsService->create($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($product);
    }

    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'price' => 'nullable|numeric',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        try {
            $product = $this->productsService->update($id, $data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json($product);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $this->productsService->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return response()->json(null, 204);
    }
}
