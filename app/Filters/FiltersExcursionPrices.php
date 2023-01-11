<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filters\Filter;

class FiltersExcursionPrices implements Filter
{
    public function __invoke(Builder $query, $price, string $property): Builder
    {
        //TODO this will work if:
        // - save prices in usd only,
        // - clear old prices after change excursion type
        $currency = currency()->getUserCurrency();
        $from = isset($price['from']) ? (int)currency($price['from'], $currency, 'USD', false) : 0;
        $to = isset($price['to']) ? (int)currency($price['to'], $currency, 'USD', false) : 10000;

        return $query->havingBetween(DB::raw('MIN(excursion_prices.price)'), [$from, $to]);
    }
}
