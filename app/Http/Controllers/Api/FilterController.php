<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ExcursionsParamsService;
use App\Services\ExcursionsSearchService;
use App\Services\ToursParamsService;
use App\Services\ToursSearchService;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getExcursionsParams(Request $request)
    {

        $excursions = ExcursionsParamsService::get($request, 'duration');

        if ($count = $excursions->count()) {
            $durationMin = (int)$excursions->first()->duration;
            $durationMax = (int)$excursions->last()->duration;

            $priceMin = (int)$excursions->min('price');
            $priceMax = (int)$excursions->max('price');

            $types = array_unique($excursions->reduce(function ($carry, $item) {
                foreach ($item->types as $type) {
                    $carry[] = ['name' => $type->name, 'id' => $type->id];
                }
                return $carry;
            }, []), SORT_REGULAR);

            return response()->json(compact('count', 'priceMin', 'priceMax', 'durationMin', 'durationMax', 'types'));
        }
        return response()->json(compact('count'));
    }

    public function getExcursions(Request $request)
    {
        $excursions = (new ExcursionsSearchService($request))->get();
        return response()->json($excursions);
    }

    public function getToursParams(Request $request)
    {
        $tours = ToursParamsService::get($request, 'days');

        if ($count = $tours->count()) {
            $durationMin = (int)$tours->first()->days;
            $durationMax = (int)$tours->last()->days;

            $types = array_unique($tours->reduce(function ($carry, $item) {
                foreach ($item->types as $type) {
                    $carry[] = ['name' => $type->name, 'id' => $type->id];
                }
                return $carry;
            }, []), SORT_REGULAR);

            $priceMin = (int)$tours->min('price');
            $priceMax = (int)$tours->max('price');

            return response()->json(compact('count', 'priceMin', 'priceMax', 'durationMin', 'durationMax', 'types'));
        }
        return response()->json(compact('count'));
    }

    public function getTours(Request $request)
    {
        $tours = (new ToursSearchService($request))->get();
        return response()->json($tours);
    }
}
