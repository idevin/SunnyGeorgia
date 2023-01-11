<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionType implements Filter
{
    public function __invoke(Builder $query, $types, string $property): Builder
    {
        return $query->whereHas('types', function ($query) use ($types) {
            $query->whereIn('id', $types);
        });
    }
}
