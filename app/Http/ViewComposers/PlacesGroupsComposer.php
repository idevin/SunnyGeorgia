<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use App\PlacesGroup;
use Illuminate\View\View;

class PlacesGroupsComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $placeGroups = \Cache::rememberForever('app:placeGroups:' . app()->getLocale(), function () {
            return PlacesGroup::all()->load(
                [
                    'translations',
                    'places',
                    'places.translations'
                ]
            );
        });
        $view->with('composer_groupPlaces', $placeGroups);
    }
}
