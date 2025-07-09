<?php

namespace App\Shared\Traits;

use App\Shared\Requests\GetAllRequest;
use App\Shared\Resources\AutocompleteResource;
use App\Shared\Services\SharedService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

trait HasAutocomplete
{
    protected SharedService $sharedService;
    public function __construct(
        SharedService $sharedService,
    ) {
        $this->sharedService = $sharedService;
    }

    public function allAutocomplete(
        GetAllRequest $request,
        string $entityClass,
        string $modelClass,
        string $resourceColumn = 'description',
        bool $availabelData = false,
    ): JsonResponse {
        $query = $this->sharedService->query(
            $request,
            $entityClass,
            $modelClass,
            $resourceColumn,
            $availabelData,
        );

        $collection = collect($query['collection'])->map(
            fn($item): AutocompleteResource => new AutocompleteResource(
                $item,
                $resourceColumn,
            )
        );

        return response()->json($collection);
    }

    public function autocomplete(
        Model $model,
        string $serviceName,
        string $modelName,
        string $resourceColumn = 'description',
    ): JsonResponse {
        $modelValidated = $this->$serviceName->validate($model, $modelName);
        return response()->json(
            new AutocompleteResource(
                $modelValidated,
                $resourceColumn,
            )
        );
    }
}
