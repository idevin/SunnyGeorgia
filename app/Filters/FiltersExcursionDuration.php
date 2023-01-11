<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionDuration implements Filter
{
    public function __invoke(Builder $query, $duration, string $property): Builder
    {
        if (is_array($duration[0])) {
            return $query->whereBetween('duration', [
                $duration[0][0], $duration[0][1],
            ])->orWhereBetween('duration', [
                $duration[1][0], $duration[1][1]
            ]);
        }
        return $query->whereBetween('duration', [$duration[0], $duration[1]]);
    }
}
