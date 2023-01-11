<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 29.08.2018
 * Time: 13:12
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Cache;


class TranslationsController extends Controller
{

    public function jsLangs($locale)
    {
        $strings = Cache::rememberForever($locale . '-lang.js', function () use ($locale) {
            $files = glob(resource_path('lang/' . $locale . '/*.php'));
            $strings = [];

            foreach ($files as $file) {
                $name = basename($file, '.php');
                $strings[$name] = require $file;
            }

            return $strings;
        });

        header('Content-Type: text/javascript');
        echo('window.i18n = ' . json_encode($strings) . ';');
        exit();
    }
}