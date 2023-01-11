<?php

namespace App\Services;

use App\Filters\FiltersExcursionEmail;
use App\Filters\FiltersExcursionTitle;
use App\Filters\FiltersIgnored;
use App\Filters\FiltersTourAvailabilities;
use App\Filters\FiltersTourDuration;
use App\Filters\FiltersTourPrices;
use App\Filters\FiltersTourType;
use App\Models\Tours\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class ToursSearchService
{
    private Request $request;

    function __construct($fields)
    {

        if ($fields instanceof Request) {
            $this->request = $fields;
        } else {
            $searchRequest = new Request();
            $searchRequest->setMethod('GET');
            $searchRequest->query->add($fields);

            $this->request = $searchRequest;
        }
        if (request()->has('page')) {
            $this->request->query->add([
                'page' => request()->input('page')
            ]);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(int $limit = 10, bool $published = true, bool $reviewed = true, array $with = [])
    {
        $relations = array_merge(['ribbon', 'media'], $with);

        $tours = $this->query()
            ->where('tours.published', $published)
            ->where('reviewed', $reviewed)
            ->with($relations)
            ->paginate($limit);
        return  $this->updateCurrency($tours);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function updateCurrency($tours)
    {
        $currency = session()->get('currency', currency()->getCurrency());
        if(is_array($currency)) {
            $currencyCode = $currency['code'];
        } else {
            $currencyCode = $currency;
        }

        if ($currencyCode !== 'USD') {
            $tours->getCollection()->transform(function ($tour) use ($currencyCode) {
                $tour->price = (int)currency(
                    $tour->price,
                    'USD',
                    $currencyCode,
                    false
                );
                return $tour;
            });
        }
        return $tours;
    }

    private function query(): QueryBuilder
    {
        return QueryBuilder::for(Tour::class)
            ->join('accommodations', 'tours.id', '=', 'accommodations.tour_id')
            ->join('accommodation_availabilities', 'accommodations.id', '=', 'accommodation_availabilities.accommodation_id')
            ->join('place_translations', function ($join) {
                $join->on('tours.start_place_id', '=', 'place_translations.place_id')
                    ->where('place_translations.locale', '=', app()->getLocale());
            })
            ->select([
                'tours.id',
                'tours.start_place_id',
                'tours.user_id',
                'tours.days',
                'tours.nights',
                'tours.ribbon_id',
                'tours.updated_at',
                'tours.reviewed',
                'tours.published',
                'tours.score',
                'place_translations.name as place_name',
                DB::raw('MIN(accommodations.price_adult) as price'),
            ])
            ->withCount(['reviews', 'generatedReviews'])
            ->groupBy('tours.id', 'place_translations.name')
            ->defaultSort('-tours.score', '-tours.updated_at')
            ->allowedSorts([
                'price',
                AllowedSort::field('score', 'tours.score'),
                AllowedSort::field('created_at', 'tours.created_at'),
                AllowedSort::field('duration', 'days'),
                AllowedSort::field('discount', 'ribbon_id'),
            ])
            ->allowedFilters([
                AllowedFilter::custom('title', new FiltersExcursionTitle()),
                AllowedFilter::custom('email', new FiltersExcursionEmail()),
                AllowedFilter::exact('place', 'start_place_id'),
                AllowedFilter::custom('date', new FiltersTourAvailabilities())
                    ->default(Carbon::tomorrow())
                ,
                AllowedFilter::custom('types', new FiltersTourType()),
                AllowedFilter::custom('price', new FiltersTourPrices()),
                AllowedFilter::custom('duration', new FiltersTourDuration()),

                // u filtra otkluchen prefiks, poetomu vse query parametri on vosprinimaet kak svoi
                // poetomu ignorim
                AllowedFilter::exact('sort')->ignore(
                    ['duration', '-duration', 'price', '-price', 'created_at', 'discount', 'id', '-id', 'score', '-score']
                ),
                AllowedFilter::exact('page')->ignore(range(1, 100)),
                AllowedFilter::exact('preview')->ignore(true),
                AllowedFilter::custom('utm_source', new FiltersIgnored()),
                AllowedFilter::custom('utm_medium', new FiltersIgnored()),
                AllowedFilter::custom('utm_campaign', new FiltersIgnored()),
                AllowedFilter::custom('utm_content', new FiltersIgnored()),
                AllowedFilter::custom('utm_term', new FiltersIgnored()),
            ]);
    }
}
