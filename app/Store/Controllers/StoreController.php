<?php

namespace App\Store\Controllers;

use App\Store\Models\Store;
use App\Store\Requests\StoreCreateRequest;
use App\Store\Requests\StoreUpdateRequest;
use App\Store\Resources\StoreResource;
use App\Store\Services\StoreService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use Illuminate\Http\JsonResponse;
use DB;

class StoreController extends Controller
{

    protected StoreService $storeService;
    protected SharedService $sharedService;

    public function __construct(StoreService $storeService, SharedService $sharedService)
    {
        $this->storeService = $storeService;
        $this->sharedService = $sharedService;
    }

    public function create(StoreCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newStore = $this->sharedService->convertCamelToSnake($request->validated());
            $this->storeService->create($newStore);
            DB::commit();
            return response()->json(['message' => 'Store created.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }

    public function delete(Store $store): JsonResponse
    {
        DB::beginTransaction();
        try {
            $storeValidated = $this->storeService->validate($store, 'Store');
            $this->storeService->delete($storeValidated);
            DB::commit();
            return response()->json(['message' => 'Store deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }

    public function get(Store $store): JsonResponse
    {
        $storeValidated = $this->storeService->validate($store, 'Store');
        return response()->json(new StoreResource($storeValidated));
    }

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Store',
            'Store',
            'address'
        );

        return response()->json(new GetAllCollection(
            StoreResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
    }

    public function update(StoreUpdateRequest $request, Store $store): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editStore = $this->sharedService->convertCamelToSnake($request->validated());
            $storeValidated = $this->storeService->validate($store, 'Store');
            $this->storeService->update($storeValidated, $editStore);
            DB::commit();
            return response()->json(['message' => 'Store updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' =>  $e->getMessage()]);
        }
    }
}
