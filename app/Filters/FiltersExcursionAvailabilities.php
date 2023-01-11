<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionAvailabilities implements Filter
{
    public function __invoke(Builder $query, $value, string $property): Builder
    {
        if ($value === 'all') {
            return $query->whereHas('availabilities', function (Builder $query) {
                $query->whereDate('date', '>=', Carbon::tomorrow())
                    ->where('amount', '>', 0);
            });
        }
        return $query->whereHas('availabilities', function (Builder $query) use ($value) {
            $query->whereDate('date', $value)
                ->where('amount', '>', 0);
        });
    }
}
