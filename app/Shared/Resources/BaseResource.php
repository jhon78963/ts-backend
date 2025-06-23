<?php

namespace App\Shared\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class BaseResource extends JsonResource
{
    protected function dateFormat($date): ?string
    {
        if ($date === null) {
            return null;
        }

        try {
            if ($date instanceof Carbon) {
                return $date->setTimezone('America/Lima')->format('d/m/Y H:i:s');
            }

            // Intentar con formatos comunes
            return Carbon::parse($date)
                ->setTimezone('America/Lima')
                ->format('d/m/Y H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}
