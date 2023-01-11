<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionTitle implements Filter
{
    public function __invoke(Builder $query, $title, string $property): Builder
    {
        return $query->whereTranslationLike('title', '%' . $title . '%');
    }
}
