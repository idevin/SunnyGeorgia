<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class UserComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (auth()->user()) {
            $view->with('composer_user', \Auth::user()->load('avatar'));
        }
    }
}
