<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CategoriesService;
use Illuminate\Http\Request;

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

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $products = $this->categoriesService->getAll();
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
            $product = $this->categoriesService->getById($id);
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
            'description' => 'nullable',
        ]);

        try {
            $product = $this->categoriesService->create($data);
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
            'description' => 'nullable|string',
        ]);

        try {
            $product = $this->categoriesService->update($id, $data);
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
            $this->categoriesService->delete($id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }

        return response()->json(null, 204);
    }
}
