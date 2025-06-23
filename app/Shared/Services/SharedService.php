<?php
namespace App\Shared\Services;

use App\Shared\Requests\GetAllRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Arr;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Str;

class SharedService
{
    private int $limit = 10;
    private int $page = 1;
    private string $search = '';
    private string $schedule = '';
    private int $gender = 0;
    private string $status = '';
    private string $startDate = '';
    private string $endDate = '';

    public function convertCamelToSnake(array $data): array
    {
        return Arr::mapWithKeys($data, function ($value, $key): array {
            return [Str::snake($key) => $value];
        });
    }

    public function dateFormat($date): string|null
    {
        if ($date === null) {
            return null;
        }
        $date = Carbon::createFromFormat('Y-m-d h:i:s', $date);
        $date = $date->format('d/m/Y h:i:s A');
        return $date;
    }

    public function query(
        GetAllRequest $request,
        string $entityName,
        string $modelName,
        array|string|null $columnSearch = null,
        array $computedColumns = []
    ): array {
        $limit = $request->query('limit', $this->limit);
        $page = $request->query('page', $this->page);
        $search = $request->query('search', $this->search);

        $modelClass = "App\\$entityName\\Models\\$modelName";

        $query = $modelClass::query()->where('is_deleted', false);

        if ($search) {
            $query = $this->searchFilter($query, $search, $columnSearch);
        }

        $total = $query->count();
        $pages = ceil($total / $limit);

        $models = $query->skip(($page - 1) * $limit)
            ->take($limit)
            ->orderBy('id', 'asc')
            ->get();

        return [
            'collection' => $models,
            'total' => $total,
            'pages' => $pages,
        ];
    }

    private function searchFilter($query, string $search, array|string $columns): Builder
    {
        $columns = is_array($columns) ? $columns : [$columns];

        return $query->where(function ($q) use ($search, $columns) {
            foreach ($columns as $column) {
                if (str_contains($column, '.')) {
                    [$relation, $field] = explode('.', $column, 2);

                    $q->orWhereHas($relation, function ($subQuery) use ($field, $search) {
                        $subQuery->whereRaw("CAST($field AS TEXT) ILIKE ?", ['%' . strtolower($search) . '%']);
                    });
                } else {
                    $q->orWhereRaw("CAST($column AS TEXT) ILIKE ?", ['%' . strtolower($search) . '%']);
                }
            }
        });
    }
}
