<?php

namespace App\Sale\Controllers;

use App\Product\Models\Product;
use App\Sale\Models\Sale;
use App\Sale\Services\SaleProductService;
use App\Product\Requests\ProductAddRequest;
use App\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use DB;

class SaleProductController extends Controller
{
    protected SaleProductService $saleProductService;

    public function __construct(SaleProductService $saleProductService)
    {
        $this->saleProductService = $saleProductService;
    }

    public function add(
        ProductAddRequest $request,
        Sale $sale,
        Product $product,
    ): JsonResponse {
        DB::beginTransaction();
        try {
            $this->saleProductService->add(
                $sale,
                $product,
                $request->validated(),
            );
            DB::commit();
            return response()->json(['message' => 'Product added.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function modify(
        ProductAddRequest $request,
        Sale $sale,
        Product $product,
    ): JsonResponse {
        DB::beginTransaction();
        try {
            $this->saleProductService->modify(
                $sale,
                $product,
                $request->validated(),
            );
            DB::commit();
            return response()->json(['message' => 'Prodct modified.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function remove(
        Sale $sale,
        Product $product,
    ): JsonResponse {
        DB::beginTransaction();
        try {
            $this->saleProductService->remove(
                $sale,
                $product->id,
            );
            DB::commit();
            return response()->json(['message' => 'Product removed.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
