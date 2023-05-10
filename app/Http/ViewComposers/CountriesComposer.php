<?php
/**
 * Created by PhpStorm.

 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use App\Repositories\CountryRepository;
use Illuminate\View\View;

class CountriesComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('composer_countries', CountryRepository::all());
    }
}