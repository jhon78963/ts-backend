<?php

namespace App\Sale\Controllers;

use App\Product\Models\Product;
use App\Product\Services\ProductService;
use App\Sale\Enums\SaleStatus;
use App\Sale\Models\Sale;
use App\Sale\Requests\SaleCreateRequest;
use App\Sale\Requests\SaleUpdateRequest;
use App\Sale\Resources\SaleResource;
use App\Sale\Services\SaleService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use App\Shared\Traits\HasAutocomplete;
use Illuminate\Http\JsonResponse;
use DB;

class SaleController extends Controller
{
    use HasAutocomplete;
    protected SaleService $saleService;
    protected ProductService $productService;
    protected SharedService $sharedService;

    public function __construct(
        SaleService $saleService,
        ProductService $productService,
        SharedService $sharedService,
    ) {
        $this->saleService = $saleService;
        $this->productService = $productService;
        $this->sharedService = $sharedService;
    }

    public function create(SaleCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newSale = $this->sharedService->convertCamelToSnake($request->validated());
            $sale = $this->saleService->create($newSale);
            DB::commit();
            return response()->json([
                'message' => 'Sale created.',
                'saleId' => $sale->id,
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Sale $sale): JsonResponse
    {
        DB::beginTransaction();
        try {
            $saleValidated = $this->saleService->validate($sale, 'Sale');
            $this->saleService->update($saleValidated, ['status' => SaleStatus::Cancelled]);
            $this->saleService->delete($saleValidated);
            DB::commit();
            return response()->json(['message' => 'Sale deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function get(Sale $sale): JsonResponse
    {
        $saleValidated = $this->saleService->validate($sale, 'Sale');
        return response()->json(new SaleResource($saleValidated));
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
            'Sale',
            'Sale',
            ['id', 'customer.full_name']
        );

        return response()->json(new GetAllCollection(
            SaleResource::collection($query['collection']),
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
            true,
        );
    }

    public function update(SaleUpdateRequest $request, Sale $sale): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editSale = $this->sharedService->convertCamelToSnake($request->validated());
            $saleValidated = $this->saleService->validate($sale, 'Sale');
            $this->saleService->update($saleValidated, $editSale);
            DB::commit();
            return response()->json(['message' => 'Sale updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
