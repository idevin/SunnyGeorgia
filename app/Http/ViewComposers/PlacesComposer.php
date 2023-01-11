<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use App\Place;
use Illuminate\View\View;

class PlacesComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $places = \Cache::rememberForever('app:places:' . app()->getLocale(), function () {
            return Place::wherePublished(true)->with(['translations' => function ($query) {
                $query->select('name', 'place_id', 'locale');
            }])->get();
        });
        $view->with('composer_places', $places);
    }
}