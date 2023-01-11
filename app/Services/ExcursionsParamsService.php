<?php

namespace App\Services;

use App\Filters\FiltersExcursionAvailabilities;
use App\Models\Excursions\Excursion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ExcursionsParamsService
{
    public static function get(Request $request, string $sortBy = '')
    {
        $excursions = $excursions = QueryBuilder::for(Excursion::class)
            ->join('excursion_prices', function ($join) {
                $join->on('excursions.id', '=', 'excursion_prices.excursion_id')
                    ->whereNotNull('price')
                    ->whereRaw("
                        ( CASE
                            WHEN excursions.type = 'person' 
                                THEN excursion_prices.price_type = 'adult'
                            WHEN excursions.type = 'group' 
                                THEN excursion_prices.price_type = 'group'
                        END )
                    ");
            })
            ->join('place_translations', function ($join) {
                $join->on('excursions.place_id', '=', 'place_translations.place_id')
                    ->where('place_translations.locale', '=', app()->getLocale());
            })
            ->select([
                'excursions.id',
                'excursions.type',
                'excursions.place_id',
                'excursions.duration',
                'excursions.type',
                'place_translations.name as place_name',
                DB::raw('MIN(excursion_prices.price) as price'),
            ])
            ->where('published', true)
            ->where('reviewed', true)
            ->groupBy('excursions.id', 'place_translations.name')
            ->allowedFilters([
                AllowedFilter::exact('place', 'place_id'),
                AllowedFilter::custom('date', new FiltersExcursionAvailabilities()),
            ])
            ->with([
                'types',
                'types.translations'
            ])
            ->get()
            ->sortBy($sortBy)
            ->values();

        $currency = currency()->getUserCurrency();
        if ($currency !== 'USD') {
            $excursions->transform(function ($excursion) use ($currency) {
                $excursion->price = currency(
                    $excursion->price,
                    'USD',
                    $currency,
                    false
                );
                return $excursion;
            });
        }
        return $excursions;
    }
}
