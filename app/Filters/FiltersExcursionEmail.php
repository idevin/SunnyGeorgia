<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionEmail implements Filter
{
    public function __invoke(Builder $query, $email, string $property): Builder
    {
        return $query->whereHas('user', function ($query) use ($email) {
            $query->where('email', 'like', '%' . $email . '%');
        });
    }
}
