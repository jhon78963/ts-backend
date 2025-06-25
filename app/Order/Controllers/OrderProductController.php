<?php

namespace App\Order\Controllers;

use App\Order\Models\Order;
use App\Order\Services\OrderProductService;
use App\Product\Models\Product;
use App\Product\Requests\ProductAddRequest;
use App\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use DB;

class OrderProductController extends Controller
{
    protected OrderProductService $orderProductService;

    public function __construct(OrderProductService $orderProductService)
    {
        $this->orderProductService = $orderProductService;
    }

    public function add(
        ProductAddRequest $request,
        Order $order,
        Product $product,
    ): JsonResponse {
        DB::beginTransaction();
        try {
            $this->orderProductService->add(
                $order,
                $product,
                $request->validated(),
            );
            DB::commit();
            return response()->json(['message' => 'Product added.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }

    public function modify(
        ProductAddRequest $request,
        Order $order,
        Product $product,
    ): JsonResponse {
        DB::beginTransaction();
        try {
            $this->orderProductService->modify(
                $order,
                $product,
                $request->validated(),
            );
            DB::commit();
            return response()->json(['message' => 'Product modified.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }

    public function remove(
        Order $order,
        Product $product,
    ): JsonResponse {
        DB::beginTransaction();
        try {
            $this->orderProductService->remove(
                $order,
                $product->id,
            );
            DB::commit();
            return response()->json(['message' => 'Product removed.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }
}
