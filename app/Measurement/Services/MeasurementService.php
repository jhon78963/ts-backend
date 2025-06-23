<?php

namespace App\Measurement\Services;

use App\Measurement\Models\Measurement;
use App\Shared\Services\ModelService;

class MeasurementService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newMeasurement): Measurement
    {
        return $this->modelService->create(new Measurement(), $newMeasurement);
    }

    public function delete(Measurement $measurement): void
    {
        $this->modelService->delete($measurement);
    }

    public function update(Measurement $measurement, array $editMeasurement): void
    {
        $this->modelService->update($measurement, $editMeasurement);
    }

    public function validate(Measurement $measurement, string $modelName): Measurement
    {
        return $this->modelService->validate($measurement, $modelName);
    }
}
