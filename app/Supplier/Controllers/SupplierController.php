<?php

namespace App\Supplier\Controllers;

use App\Shared\Traits\HasAutocomplete;
use App\Supplier\Models\Supplier;
use App\Supplier\Requests\SupplierCreateRequest;
use App\Supplier\Requests\SupplierUpdateRequest;
use App\Supplier\Resources\SupplierResource;
use App\Supplier\Services\SupplierService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use Illuminate\Http\JsonResponse;
use DB;

class SupplierController extends Controller
{
    use HasAutocomplete;
    protected SupplierService $supplierService;
    protected SharedService $sharedService;

    public function __construct(SupplierService $supplierService, SharedService $sharedService)
    {
        $this->supplierService = $supplierService;
        $this->sharedService = $sharedService;
    }

    public function create(SupplierCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newSupplier = $this->sharedService->convertCamelToSnake($request->validated());
            $this->supplierService->create($newSupplier);
            DB::commit();
            return response()->json(['message' => 'Supplier created.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Supplier $supplier): JsonResponse
    {
        DB::beginTransaction();
        try {
            $supplierValidated = $this->supplierService->validate($supplier, 'Supplier');
            $this->supplierService->delete($supplierValidated);
            DB::commit();
            return response()->json(['message' => 'Supplier deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function get(Supplier $supplier): JsonResponse
    {
        $supplierValidated = $this->supplierService->validate($supplier, 'Supplier');
        return response()->json(new SupplierResource($supplierValidated));
    }

    public function getAutocomplete(Supplier $supplier): JsonResponse
    {
        return $this->autocomplete(
            $supplier,
            'supplierService',
            'Supplier',
            'business_name',
        );
    }

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Supplier',
            'Supplier',
            ['ruc', 'business_name', 'manager', 'address']
        );

        return response()->json(new GetAllCollection(
            SupplierResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
    }

    public function getAllAutocomplete(GetAllRequest $request): JsonResponse
    {
        return $this->allAutocomplete(
            $request,
            'Supplier',
            'Supplier',
            'business_name'
        );
    }

    public function update(SupplierUpdateRequest $request, Supplier $supplier): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editSupplier = $this->sharedService->convertCamelToSnake($request->validated());
            $supplierValidated = $this->supplierService->validate($supplier, 'Supplier');
            $this->supplierService->update($supplierValidated, $editSupplier);
            DB::commit();
            return response()->json(['message' => 'Supplier updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
