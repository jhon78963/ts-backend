<?php

namespace App\Measurement\Controllers;

use App\Measurement\Models\Measurement;
use App\Measurement\Requests\MeasurementCreateRequest;
use App\Measurement\Requests\MeasurementUpdateRequest;
use App\Measurement\Resources\MeasurementResource;
use App\Measurement\Services\MeasurementService;
use App\Shared\Controllers\Controller;
use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\GetAllCollection;
use App\Shared\Services\SharedService;
use App\Shared\Traits\HasAutocomplete;
use Illuminate\Http\JsonResponse;
use DB;

class MeasurementController extends Controller
{
    use HasAutocomplete;
    protected MeasurementService $measurementService;
    protected SharedService $sharedService;

    public function __construct(MeasurementService $measurementService, SharedService $sharedService)
    {
        $this->measurementService = $measurementService;
        $this->sharedService = $sharedService;
    }

    public function create(MeasurementCreateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $newMeasurement = $this->sharedService->convertCamelToSnake($request->validated());
            $measurement = $this->measurementService->create($newMeasurement);
            DB::commit();
            return response()->json([
                'message' => 'Measurement created.',
                'item' => [
                    'id' => $measurement->id,
                    'value' => $measurement->description
                ],
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete(Measurement $measurement): JsonResponse
    {
        DB::beginTransaction();
        try {
            $measurementValidated = $this->measurementService->validate($measurement, 'Measurement');
            $this->measurementService->delete($measurementValidated);
            DB::commit();
            return response()->json(['message' => 'Measurement deleted.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function get(Measurement $measurement): JsonResponse
    {
        $measurementValidated = $this->measurementService->validate($measurement, 'Measurement');
        return response()->json(new MeasurementResource($measurementValidated));
    }

    public function getAutocomplete(Measurement $measurement): JsonResponse
    {
        return $this->autocomplete(
            $measurement,
            'measurementService',
            'Measurement'
        );
    }

    public function getAll(GetAllRequest $request): JsonResponse
    {
        $query = $this->sharedService->query(
            $request,
            'Measurement',
            'Measurement',
            ['id', 'description']
        );

        return response()->json(new GetAllCollection(
            MeasurementResource::collection($query['collection']),
            $query['total'],
            $query['pages'],
        ));
    }

    public function getAllAutocomplete(GetAllRequest $request): JsonResponse
    {
        return $this->allAutocomplete(
            $request,
            'Measurement',
            'Measurement'
        );
    }

    public function update(MeasurementUpdateRequest $request, Measurement $measurement): JsonResponse
    {
        DB::beginTransaction();
        try {
            $editMeasurement = $this->sharedService->convertCamelToSnake($request->validated());
            $measurementValidated = $this->measurementService->validate($measurement, 'Measurement');
            $this->measurementService->update($measurementValidated, $editMeasurement);
            DB::commit();
            return response()->json(['message' => 'Measurement updated.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
