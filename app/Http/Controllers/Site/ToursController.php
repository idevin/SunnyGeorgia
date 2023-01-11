<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use App\Models\Tours\Accommodation;
use App\Models\Tours\Tour;
use App\Services\PlacesSearchService;
use App\Services\ToursSearchService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Spatie\SchemaOrg\Schema;

class ToursController extends Controller
{
    protected array $errors = [];

    public function index(Request $request)
    {
        $places = (new PlacesSearchService('tours'))->get();

        $page = Page::whereTranslation('slug', 'tours', app()->getLocale())
            ->orWhereTranslation('slug', 'tours', 'ru')
            ->first();

        $meta = [
            "title" => (isset($page)) ? $page->getMetaTitle() : null,
            "description" => (isset($page)) ? $page->getMetaDesc() : null,
        ];

        $cssChunks = [];
        foreach (File::files(public_path('css/tours-list')) as $file) {
            $fileName = File::basename($file);
            $fileExt = File::extension($file);
            if (strncmp($fileName, 'tours-list', strlen('tours-list')) !== 0 && $fileExt === 'css') {
                $cssChunks[] = 'css/tours-list/' . File::basename($file);
            }
        }

        $currency = session()->get('currency', currency()->getCurrency());
        if(is_array($currency)) {
            $currencyCode = $currency['code'];
        } else {
            $currencyCode = $currency;
        }
        return view('site.tours-list.index',
            compact(
                'meta',
                'cssChunks',
                'currencyCode',
                'places'
            )
        )->withErrors($this->errors);

    }

    public function view(Tour $tour, Request $request)
    {
        $tour->load([
            'place',
            'place.translations' => function ($query) {
                $query->select('name', 'place_id', 'locale');
            },
            'places',
            'places.translations' => function ($query) {
                $query->select('name', 'place_id', 'locale');
            },
            'priceOptions',
            'options',
            'options.translations',
            'foodOption',
            'parts'
        ])->append('minPrice');

        $reviews = $tour->reviews->where('published', true);
        $reviews = $reviews->merge($tour->generatedReviews->where('published', true));
        $avgRating = $this->calculateAvgRating($tour->getRating(), $tour->getGeneratedRating());

        if ((!$tour->published || !$tour->reviewed)) {
            if (\Auth::guest()) abort(404);
            $user = \Auth::user();

            if (!($request->input('preview') === 'true' && ($user->id == $tour->user_id || $user->hasRole('admin')))) {
                abort(404);
            }
        }

        $place = $tour->place;
        $placeGroup = $tour->place->placesGroup;
        $placeGroup->load([
            'places',
            'places.translations' => function ($query) {
                $query->select('name', 'place_id', 'locale');
            },
            'places.images'
        ]);

        $availability = $tour->availability()
            ->whereDate('date', '>', Carbon::today()->toDateString())
            ->where('amount', '>', 0)
            ->orderBy('date')
            ->select(['accommodation_id', 'discount_percent', 'date'])
            ->get()
            ->groupBy(function ($item) {
                return $item['date'];
            });

        //getting similar for aside
        $asideData = [
            'tours' => (new ToursSearchService([
                'place' => $tour->place_id
            ]))->get(6)
            ,
        ];

        $description = '';
        $price = money_view($tour->minPrice);

        //todo доделать схему
        $offerSchema = Schema::offer()
            ->availability(Schema::itemAvailability()::InStock)
            ->price($price)
            ->priceCurrency(currency()->getUserCurrency())
            ->description($description)
            ->itemOffered(Schema::travelAction()
                ->description($description)
            );

        $vat = $tour->partner->vat;

        $cssChunks = [];
        foreach (File::files(public_path('css/tour')) as $file) {
            $fileName = File::basename($file);
            $fileExt = File::extension($file);
            if (strncmp($fileName, 'tour', strlen('tour')) !== 0 && $fileExt === 'css') {
                $cssChunks[] = 'css/tour/' . File::basename($file);
            }
        }

        $gallery = $tour->getMedia('tours');

        $slider = [];
        $thumbs = [];
        foreach ($gallery as $item) {
            $slider[] = [
                'origin' => $item->getUrl(),
                'webp' => [
                    '825w' => $item->getUrl('slider-big-webp'),
                    '690w' => $item->getUrl('slider-med-webp'),
                    '510w' => $item->getUrl('slider-small-webp'),
                    '345w' => $item->getUrl('slider-mobile-webp'),
                ],
                'jpeg' => [
                    '825w' => $item->getUrl('slider-big'),
                    '690w' => $item->getUrl('slider-med'),
                    '510w' => $item->getUrl('slider-small'),
                    '345w' => $item->getUrl('slider-mobile'),
                ],
            ];
            $thumbs[] = [
                'origin' => $item->getUrl('thumb'),
                'webp' => $item->getUrl('thumb-webp')
            ];
        }

        return view('site.tours.tour',
            compact(
                'tour',
                'availability',
                'placeGroup',
                'place',
                'asideData',
                'avgRating',
                'reviews',
                'vat',
                'cssChunks',
                'slider',
                'thumbs'
            )
        );
    }

    protected function calculateAvgRating($rating = null, $generatedRating = null)
    {
        if ($rating && $generatedRating) {
            return ($rating + $generatedRating) / 2;
        } else {
            if ($rating) return $rating;
            if ($generatedRating) return $generatedRating;
            return 0;
        }
    }

    public function accommodations(Request $request)
    {
        $accommodations = Accommodation::find($request->input('accommodations', []))
            ->sortBy('price_adult')
            ->groupBy('hotel');
        return response()->json(compact('accommodations'));
    }
}
