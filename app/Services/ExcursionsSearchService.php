<?php
/**
 * Created by PhpStorm.

 * Date: 16.02.2018
 * Time: 18:50
 */

namespace App\Services;

use App\Filters\FiltersExcursionAvailabilities;
use App\Filters\FiltersExcursionDuration;
use App\Filters\FiltersExcursionEmail;
use App\Filters\FiltersExcursionPlace;
use App\Filters\FiltersExcursionPrices;
use App\Filters\FiltersExcursionTitle;
use App\Filters\FiltersExcursionType;
use App\Filters\FiltersIgnored;
use App\Models\Excursions\Excursion;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ExcursionsSearchService
{
    private $request;

    function __construct($fields)
    {
        if ($fields instanceof \Illuminate\Http\Request) {
            $this->request = $fields;
        } else {
            $searchRequest = new \Illuminate\Http\Request();
            $searchRequest->setMethod('GET');
            $searchRequest->query->add($fields);

            $this->request = $searchRequest;
        }
    }

    public function get(
        int $limit = 10,
        bool $published = true,
        bool $reviewed = true,
        array $with = []
    )
    {
        $relations = array_merge([
            'ribbon',
            'media',
            'place',
            'place.translations'
//            'places' => function ($query) {
//                $query->join('place_translations', function ($join) {
//                    $join->on('places.id', '=', 'place_translations.place_id')
//                        ->where('locale', '=', app()->getLocale());
//                })
//                    ->select(['places.id', 'place_translations.name']);
//            },
        ], $with
        );
        $excursions = $this->query()
            ->where('published', $published)
            ->where('reviewed', $reviewed)
            ->with($relations)
            ->paginate($limit);

        return $this->calculateCurrency($excursions);
    }

    private function query()
    {
        //      'array of things ignored by filter'
        $sorts = [
            'duration',
            '-duration',
            'price',
            '-price',
            'created_at',
            'discount',
            'id',
            '-id',
            'score',
            '-score',
        ];

        return QueryBuilder::for(Excursion::class, $this->request)
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
                'excursions.user_id',
                'excursions.duration',
                'excursions.ribbon_id',
                'excursions.updated_at',
                'excursions.reviewed',
                'excursions.score',
                'excursions.published',
                'place_translations.name as place_name',
                DB::raw('MIN(excursion_prices.price) as price'),
            ])
            ->withCount(['reviews', 'generatedReviews'])
            ->groupBy('excursions.id', 'place_translations.name')
            ->defaultSort('-excursions.score', '-excursions.updated_at')
            ->allowedSorts([
                'duration',
                'price',
                AllowedSort::field('score', 'excursions.score'),
                AllowedSort::field('created_at', 'excursions.created_at'),
                AllowedSort::field('updated_at', 'excursions.updated_at'),
                AllowedSort::field('discount', 'ribbon_id'),
            ])
            ->allowedFilters(

            // u filtra otkluchen prefiks, poetomu vse query parametri on vosprinimaet kak svoi
            // poetomu ignorim v ruchnuju
                AllowedFilter::exact('sort')->ignore($sorts),
                AllowedFilter::exact('preview')->ignore(true),
                AllowedFilter::exact('page')->ignore(range(1, 100)),
                AllowedFilter::custom('utm_source', new FiltersIgnored()),
                AllowedFilter::custom('utm_medium', new FiltersIgnored()),
                AllowedFilter::custom('utm_campaign', new FiltersIgnored()),
                AllowedFilter::custom('utm_content', new FiltersIgnored()),
                AllowedFilter::custom('utm_term', new FiltersIgnored()),

                AllowedFilter::custom('title', new FiltersExcursionTitle()),
                AllowedFilter::custom('email', new FiltersExcursionEmail()),
                AllowedFilter::exact('place', 'excursions.place_id'),
//                AllowedFilter::custom('place', new FiltersExcursionPlace()),
                AllowedFilter::custom('date', new FiltersExcursionAvailabilities())->default('all'),
                AllowedFilter::custom('price', new FiltersExcursionPrices()),
                AllowedFilter::custom('duration', new FiltersExcursionDuration()),
                AllowedFilter::custom('types', new FiltersExcursionType()),
                AllowedFilter::exact('kind', 'excursions.type')
            );
    }

    private function calculateCurrency($excursions)
    {
        $currency = currency()->getUserCurrency();
        if ($currency !== 'USD') {
            $excursions->getCollection()->transform(function ($excursion) use ($currency) {
                $excursion->price =
                    (int)currency(
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
