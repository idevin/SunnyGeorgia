<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use App\Language;
use Illuminate\View\View;

class LanguagesComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $langs = \Cache::rememberForever('app:languages', function () {
            return Language::all();
        });
        $view->with('languages', $langs);
        $view->with('defaultLang', config('app.locale'));
    }
}
