<?php
/**
 * Created by PhpStorm.

 * Date: 26.07.2018
 * Time: 16:03
 */

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use App\Place;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Watson\Sitemap\Facades\Sitemap;

class SitemapsController extends Controller
{

    protected $languages;

    public function __construct()
    {
        $this->languages = LaravelLocalization::getSupportedLanguagesKeys();
    }

    public function index()
    {
        $excursions = Excursion::with('translations')
            ->wherePublished(true)
            ->whereReviewed(true)
            ->get();
        $tours = Tour::with('translations')
            ->wherePublished(true)
            ->whereReviewed(true)
            ->get();
        $places = Place::all()->load('translations');

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('main')),
            null,
            'weekly',
            0.8,
            $this->makeAlternate('main')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('contacts')),
            null,
            'weekly',
            0.8,
            $this->makeAlternate('contacts')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('rules')),
            null,
            'weekly',
            0.6,
            $this->makeAlternate('rules')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('qa')),
            null,
            'weekly',
            0.6,
            $this->makeAlternate('qa')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('about')),
            null,
            'weekly',
            0.7,
            $this->makeAlternate('about')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('be-partner')),
            null,
            'weekly',
            0.7,
            $this->makeAlternate('be-partner')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('terms')),
            null,
            'weekly',
            0.7,
            $this->makeAlternate('terms')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('excursions.index')),
            null,
            'hourly',
            0.8,
            $this->makeAlternate('excursions.index')
        );

        $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('tours.index')),
            null,
            'hourly',
            0.8,
            $this->makeAlternate('tours.index')
        );


        foreach ($excursions as $excursion) {
            if ($excursion->slug)
                $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('excursions.view', ['excursion' => $excursion->{'slug:ru'}])),
                    $excursion->updated_at,
                    $excursion->deleted_at ? 'never' : 'daily',
                    1,
                    $this->makeAlternate('excursions.view', $excursion)
                );
        }
        foreach ($tours as $tour) {
            if ($tour->slug)
                $this->addTag(LaravelLocalization::getLocalizedURL('ru', route('tours.view', ['tour' => $tour->{'slug:ru'}])),
                    $tour->updated_at,
                    $tour->deleted_at ? 'never' : 'daily',
                    1,
                    $this->makeAlternate('tours.view', $tour)
                );
        }
        foreach ($places as $place) {
            if (!$place->slug) continue;

            $this->addTag(LaravelLocalization::getLocalizedURL('ru', route($place->{'slug:ru'})),
                $place->updated_at,
                'weekly',
                0.9,
                $this->makeAlternate($place->{'slug:ru'}, $place)
            );
        }
        return Sitemap::render();
    }

    private function addTag($location, $lastModified, $changeFrequency, $priority, $alternate)
    {
        return Sitemap::addTag(new \Watson\Sitemap\Tags\MultilingualTag(
            $location,
            $lastModified,
            $changeFrequency,
            $priority,
            $alternate
        ));
    }

    private function makeAlternate($routeName, $model = null): array
    {
        $alternate = [];
        foreach ($this->languages as $language) {
            if ($model && $model->{'noindex_' . $language}) continue;
            $slug = $model->{'slug:' . $language} ?? '';
            if ($language !== 'ru')
                $alternate[$language] = LaravelLocalization::getLocalizedURL($language, route($routeName, $slug));
        }
        return $alternate;
    }
}
