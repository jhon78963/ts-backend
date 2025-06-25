<?php

namespace App\Sale\Controllers;

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
use Illuminate\Http\JsonResponse;
use DB;

class SaleController extends Controller
{
    protected SaleService $saleService;
    protected SharedService $sharedService;

    public function __construct(
        SaleService $saleService,
        SharedService $sharedService,
    ) {
        $this->saleService = $saleService;
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

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Sale',
            'Sale',
            ['id', 'customer.name', 'customer.surname', 'date', 'status']
        );

        return response()->json(new GetAllCollection(
            SaleResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
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
