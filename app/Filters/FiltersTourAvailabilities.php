<?php

namespace App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FiltersTourAvailabilities implements Filter
{
    public function __invoke(Builder $query, $date, string $property) : Builder
    {
        if(! is_array($date)){
          // $date equal to Carbon::tomorrow()
            $date = [$date, $date->copy()->addMonths(12)];
        }
        return $query->whereHas('availability', function (Builder $query) use ($date) {
            $query->whereBetween('date', $date)
                ->where('amount', '>', 0);
        });
    }
}
