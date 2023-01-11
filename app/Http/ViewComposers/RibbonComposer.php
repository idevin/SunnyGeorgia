<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use App\Ribbon;
use Illuminate\View\View;

class RibbonComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('composer_ribbons', Ribbon::with('translations')->get());
    }
}
