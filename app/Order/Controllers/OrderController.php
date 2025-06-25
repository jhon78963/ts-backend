<?php

namespace App\Order\Controllers;

use App\Order\Enums\OrderStatus;
use App\Order\Models\Order;
use App\Order\Requests\OrderCreateRequest;
use App\Order\Requests\OrderUpdateRequest;
use App\Order\Resources\OrderResource;
use App\Order\Services\OrderService;
use App\Product\Models\Product;
use App\Product\Services\ProductService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use App\Shared\Traits\HasAutocomplete;
use Illuminate\Http\JsonResponse;
use DB;

class OrderController extends Controller
{
    use HasAutocomplete;
    protected OrderService $orderService;
    protected ProductService $productService;
    protected SharedService $sharedService;

    public function __construct(
        OrderService $orderService,
        ProductService $productService,
        SharedService $sharedService,
    ) {
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->sharedService = $sharedService;
    }

    public function create(OrderCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newOrder = $this->sharedService->convertCamelToSnake($request->validated());
            $order = $this->orderService->create($newOrder);
            DB::commit();
            return response()->json([
                'message' => 'Order created.',
                'orderId' => $order->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Order $order): JsonResponse
    {
        DB::beginTransaction();
        try {
            $orderValidated = $this->orderService->validate($order, 'Order');
            $this->orderService->update($orderValidated, ['status' => OrderStatus::Cancelled]);
            $this->orderService->delete($orderValidated);
            DB::commit();
            return response()->json(['message' => 'Order deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function get(Order $order): JsonResponse
    {
        $orderValidated = $this->orderService->validate($order, 'Order');
        return response()->json(new OrderResource($orderValidated));
    }

    public function getAutocomplete(Product $product): JsonResponse
    {
        return $this->autocomplete(
            $product,
            'productService',
            'Product',
            'name',
        );
    }

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Order',
            'Order',
            ['id', 'supplier.business_name', 'supplier.manager', 'date', 'status']
        );

        return response()->json(new GetAllCollection(
            OrderResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
    }

    public function getAllAutocomplete(GetAllRequest $request): JsonResponse
    {
        return $this->allAutocomplete(
            $request,
            'Product',
            'Product',
            'name',
            false
        );
    }

    public function update(OrderUpdateRequest $request, Order $order): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editOrder = $this->sharedService->convertCamelToSnake($request->validated());
            $orderValidated = $this->orderService->validate($order, 'Order');
            $this->orderService->update($orderValidated, $editOrder);
            DB::commit();
            return response()->json(['message' => 'Order updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
