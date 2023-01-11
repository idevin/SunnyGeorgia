<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Place;
use App\Services\ExcursionsSearchService;
use App\Services\ToursSearchService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class PlaceController extends Controller
{

    public function view()
    {
        $slug = Route::currentRouteName();
        $place = Place::whereTranslation('slug', $slug)->firstOrFail();

        $place->load('translations', 'placesGroup', 'placesGroup.places');
        $placeGroup = $place->placesGroup;

        $meta = [
            "title" => (isset($place)) ? json_decode($place->meta_title, true)['main'] : null,
            "description" => (isset($place)) ? json_decode($place->meta_description, true)['main'] : null,
        ];

        $searchRequest = new \Illuminate\Http\Request();
        $searchRequest->setMethod('GET');
        $searchRequest->query->add([
            'place' => $place->id
        ]);
        $asideData = [
            'excursions' => (new ExcursionsSearchService([
                'place' => $place->id
            ]))->get(3)
            ,
            'tours' => (new ToursSearchService([
                'place' => $place->id
            ]))->get(3)
            ,
        ];
        $page = $place->page;
        $cssChunks = [];
        foreach (File::files(public_path('css/place')) as $file) {
          $fileName = File::basename($file);
          $fileExt = File::extension($file);
          if (strncmp($fileName, 'place', strlen('place')) !== 0 && $fileExt === 'css') {
            $cssChunks[] = 'css/place/' . File::basename($file);
          }
        }
        return view('site.place.index',
            compact(
                'place',
                'placeGroup',
                'meta',
                'asideData',
                'page',
              'cssChunks'
            ));
    }
}
