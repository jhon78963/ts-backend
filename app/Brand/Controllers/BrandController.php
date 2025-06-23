<?php

namespace App\Brand\Controllers;

use App\Brand\Models\Brand;
use App\Brand\Requests\BrandCreateRequest;
use App\Brand\Requests\BrandUpdateRequest;
use App\Brand\Resources\BrandResource;
use App\Brand\Services\BrandService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use App\Shared\Traits\HasAutocomplete;
use Illuminate\Http\JsonResponse;
use DB;

class BrandController extends Controller
{
    use HasAutocomplete;
    protected BrandService $brandService;
    protected SharedService $sharedService;

    public function __construct(BrandService $brandService, SharedService $sharedService)
    {
        $this->brandService = $brandService;
        $this->sharedService = $sharedService;
    }

    public function create(BrandCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newBrand = $this->sharedService->convertCamelToSnake($request->validated());
            $brand = $this->brandService->create($newBrand);
            DB::commit();
            return response()->json([
                'message' => 'Brand created.',
                'item' => [
                    'id' => $brand->id,
                    'value' => $brand->description
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Brand $brand): JsonResponse
    {
        DB::beginTransaction();
        try {
            $BrandValidated = $this->brandService->validate($brand, 'Brand');
            $this->brandService->delete($BrandValidated);
            DB::commit();
            return response()->json(['message' => 'Brand deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function get(Brand $brand): JsonResponse
    {
        $brandValidated = $this->brandService->validate($brand, 'Brand');
        return response()->json(new BrandResource($brandValidated));
    }

    public function getAutocomplete(Brand $brand): JsonResponse
    {
        return $this->autocomplete(
            $brand,
            'brandService',
            'Brand'
        );
    }

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Brand',
            'Brand',
            ['id', 'description']
        );

        return response()->json(new GetAllCollection(
            BrandResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
    }

    public function getAllAutocomplete(GetAllRequest $request): JsonResponse
    {
        return $this->allAutocomplete(
            $request,
            'Brand',
            'Brand'
        );
    }

    public function update(BrandUpdateRequest $request, Brand $brand): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editBrand = $this->sharedService->convertCamelToSnake($request->validated());
            $brandValidated = $this->brandService->validate($brand, 'Brand');
            $this->brandService->update($brandValidated, $editBrand);
            DB::commit();
            return response()->json(['message' => 'Brand updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
