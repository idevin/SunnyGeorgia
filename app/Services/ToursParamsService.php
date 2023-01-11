<?php

namespace App\Services;

use App\Filters\FiltersTourAvailabilities;
use App\Models\Tours\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ToursParamsService
{
    public static function get(Request $request, string $sortBy = '')
    {
        $tours = QueryBuilder::for(Tour::class)
            ->join('accommodations', 'tours.id', '=', 'accommodations.tour_id')
            ->join('place_translations', function ($join) {
                $join->on('tours.start_place_id', '=', 'place_translations.place_id')
                    ->where('place_translations.locale', '=', app()->getLocale());
            })
            ->select([
                'tours.id',
                'tours.start_place_id',
                'tours.days',
                'tours.nights',
                'place_translations.name as start_place_name',
                DB::raw('MIN(accommodations.price_adult) as price'),
            ])
            ->where('tours.published', true)
            ->where('tours.reviewed', true)
            ->groupBy('tours.id', 'place_translations.name')
            ->allowedFilters([
                AllowedFilter::exact('place', 'start_place_id'),
                AllowedFilter::custom('date', new FiltersTourAvailabilities())->default(Carbon::tomorrow())
            ])
            ->with([
                'types',
                'types.translations',
            ])
            ->get()
            ->sortBy($sortBy)
            ->values();

        $currency = currency()->getUserCurrency();
        if ($currency !== 'USD') {
            $tours->transform(function ($tour) use ($currency) {
                $tour->price = currency(
                    $tour->price,
                    'USD',
                    $currency,
                    false
                );
                return $tour;
            });
        }
        return $tours;
    }
}
