<?php
/**
 * Created by PhpStorm.

 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use App\Repositories\CountryCodeRepository;
use Illuminate\View\View;

class CountriesCodesComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('composer_countries_codes', CountryCodeRepository::all());
    }
}