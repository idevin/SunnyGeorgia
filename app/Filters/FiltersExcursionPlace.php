<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionPlace implements Filter
{
    public function __invoke(Builder $query, $placeId, string $property): Builder
    {
        return $query->whereHas('places', function ($query) use ($placeId) {
            $query->where('id', $placeId);
        });
    }
}
