<?php
/**
 * Created by PhpStorm.

 * Date: 04.12.2017
 * Time: 14:25
 */

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AlternatesComposer
{

    /**
     * Bind data to the view.
     * Генерит данные для языковых ссылок
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $model = null;
        $alternates = [];
        if (Route::current()) {
            $parameters = Route::current()->parameters;
            foreach ($parameters as $param) {
                if ($param instanceof \Illuminate\Database\Eloquent\Model) {
                    $model = $param;
                    break;
                }
            }
            $routeName = Route::current()->action['as'];
            $currentLocale = app()->getLocale();
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                if ($localeCode != $currentLocale) {
                    if ($model) {
                        if ($model->translate($localeCode)->slug) {
                            $alternates[$localeCode] = [
                                'url' => LaravelLocalization::getLocalizedURL(
                                    $localeCode, route($routeName, $model->translate($localeCode)->slug)
                                ),
                                'langNative' => $properties['native'],
                                'noindex' => $model->{'noindex_' . $localeCode} ?? false
                            ];
                        }
                    } else {
                        $alternates[$localeCode] = [
                            'url' => LaravelLocalization::getLocalizedURL(
                                $localeCode, route($routeName, $parameters)
                            ),
                            'langNative' => $properties['native']
                        ];
                    }
                }
            }
        }
        $view->with('alternates', $alternates);
    }
}
