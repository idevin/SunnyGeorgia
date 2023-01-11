<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 13.04.2018
 * Time: 12:04
 */

namespace App\Http\Controllers\XHR;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;


class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
//        $this->validate($request, [
//            'lat' => 'required',
//            'long' => 'required',
//            'lang' => 'in:ru,ka,en'
//        ]);


        $lat = (float)$request->input('lat', 41.616755);
        $long = (float)$request->input('long', 41.636745);
        $lang = $request->input('lang', \App::getLocale());
        if (strtolower($lang) == 'ge') $lang = 'ka';
        $data = compact('lang', 'lat', 'long');

        if ($lat > 0 && $long > 0) {

            $cacheKey = 'weather:' . $lang . ':' . $lat . ':' . $long;
            $data['weather'] = \Cache::remember($cacheKey, 0, function () use ($lat, $long, $lang) {
                try {

                    $d = \DarkSky::location($lat, $long)
                        ->language($lang)
                        ->units('si')
                        ->daily();
                    $d = collect($d)->filter(function ($item) {
                        $time = Carbon::createFromTimestamp($item->time);
                        return $time->isToday() || $time->isFuture();
                    })->transform(function ($item) {
                        $item->time = Carbon::createFromTimestamp($item->time)->startOfDay()->timestamp;
                        return $item;
                    })->sortBy('time');

                    return array_values($d->toArray());
                } catch (\Throwable $e) {
                    \Log::error($e->getMessage());
                    return [];
                }


            });
            return response()->json($data);
        } else {
            $data['weather'] = [];
            return response()->json($data);
        }
    }
}