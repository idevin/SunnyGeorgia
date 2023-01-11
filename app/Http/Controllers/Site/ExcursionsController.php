<?php

namespace App\Http\Controllers\Site;

use App\Helpers\JsonLd;
use App\Http\Controllers\Controller;
use App\Models\Excursions\Excursion;
use App\Models\Pages\Page;
use App\Services\ExcursionsSearchService;
use App\Services\PlacesSearchService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExcursionsController extends Controller
{
    public function index()
    {
        $places = (new PlacesSearchService('excursions'))->get();

        $page = Page::whereTranslation('slug', 'excursions', app()->getLocale())
            ->orWhereTranslation('slug', 'excursions', 'ru')
            ->first();

        $meta = [
            "title" => (isset($page)) ? $page->getMetaTitle() : null,
            "description" => (isset($page)) ? $page->getMetaDesc() : null,
        ];

        $cssChunks = [];
        foreach (File::files(public_path('css/excursions-list')) as $file) {
            $fileName = File::basename($file);
            $fileExt = File::extension($file);
            if (strncmp($fileName, 'excursions-list', strlen('excursions-list')) !== 0 && $fileExt === 'css') {
                $cssChunks[] = 'css/excursions-list/' . File::basename($file);
            }
        }
        $currencyCode = currency()->getUserCurrency();
        return view('site.excursions-list.index',
            compact(
                'meta',
                'cssChunks',
                'currencyCode',
                'places'
            )
        );
    }

    public function view(Excursion $excursion, Request $request)
    {
        $excursion->load([
            'place',
            'availabilityFuture',
            'currency',
            'paidOptions',
            'ribbon',
            'prices' => function ($query) use ($excursion) {
                $query->where(function ($query) use ($excursion) {
                    if ($excursion->type === 'group') {
                        $query->where('price_type', 'group');
                    } else {
                        $query->where('price_type', '!=', 'group');
                    }
                })->orderBy('price');
            }
        ]);

        $user = Auth::user();

        if ((!$excursion->published || !$excursion->reviewed)) {
            if (Auth::guest()) {
                abort(404);
            }

            if (!($request->input('preview') == 'true' && ($user->id == $excursion->user_id || $user->hasRole('admin')))) {
                abort(404);
            }
        }

        if (Auth::user()) {
            $currency = currency()->getUserCurrency();
        } else {
            $currency = session('currency', config('currency.default'));
        }

        $reviews = $excursion->reviews->where('published', true);
        $reviews = $reviews->merge($excursion->generatedReviews->where('published', true));
        $avgRating = $excursion->averageRating;

        $discount = $excursion->ribbon->discount ?? null;
        $prices = $excursion->prices->groupBy('price_type')->map(
            function ($priceGroup) use ($excursion, $currency, $discount) {
                if ($priceGroup->count() > 1) {
                    foreach ($priceGroup as $item) {
                        if ($discount) {
                            $item->price = $item->price - ceil($item->price * $discount / 100);
                        }
                        $item->price = currency($item->price, $excursion->currency->code, $currency, false);
                    }
                    return $priceGroup;
                } else {
                    if ($discount) {
                        $priceGroup[0]->price = $priceGroup[0]->price - ceil($priceGroup[0]->price * $discount / 100);
                    }
                    $priceGroup[0]->price = currency($priceGroup[0]->price, $excursion->currency->code, $currency, false);
                    return $priceGroup[0];
                }
            }
        );

        // kostil na sluchai esli cena za grupu tolko odna
        if (isset($prices['group']) && !$prices['group'] instanceof Collection) {
            $collection = collect([$prices['group']]);
            $prices['group'] = $collection;
        }

        if ($excursion->type === 'person') {
            $minPrice = $prices['adult']->price;
        } else {
            $minPrice = $prices['group']->min('price');
        }

        $availabilities = $excursion->getActualAvailabilities();

        $asideData = [
            'excursions' => (new ExcursionsSearchService([
                'place' => $excursion->place_id
            ]))->get(6)
        ];

        $jsonld = new JsonLd();
        $travelAction = $jsonld->travelAction($excursion);

        $vat = isset($excursion->partner) ? $excursion->partner->vat : 0;

        $cssChunks = [];
        foreach (File::files(public_path('css/excursion')) as $file) {
            $fileName = File::basename($file);
            $fileExt = File::extension($file);
            if (strncmp($fileName, 'excursion', strlen('excursion')) !== 0 && $fileExt === 'css') {
                $cssChunks[] = 'css/excursion/' . File::basename($file);
            }
        }

        $gallery = $excursion->getMedia('excursions');
        $slider = [];
        $thumbs = [];
        foreach ($gallery as $item) {
            $alt = $item->getCustomProperty('alt', $excursion->title);
            $mainImage = $item->hasCustomProperty('main');
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
                'alt' => $alt,
                'mainImage' => $mainImage,
            ];
            $thumbs[] = [
                'origin' => $item->getUrl('thumb'),
                'webp' => $item->getUrl('thumb-webp'),
                'alt' => $alt,
                'mainImage' => $mainImage,
            ];
        }

        return view('site.excursions.excursion',
            compact(
                'excursion',
                'reviews',
                'travelAction',
                'avgRating',
                'availabilities',
                'vat',
                'currency',
                'minPrice',
                'cssChunks',
                'slider',
                'thumbs',
                'prices',
                'asideData'
            ));
    }
}
