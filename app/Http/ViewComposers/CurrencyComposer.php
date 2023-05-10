<?php
/**
 * Created by PhpStorm.

 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class CurrencyComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $curList = \Cache::rememberForever('app:currencies:active:list', function () {
            return \App\Currency::whereActive(true)->get();
        });
        $view->with('composer_currencies', $curList);
    }
}