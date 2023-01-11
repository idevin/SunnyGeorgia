<?php

use App\Option;
use App\OptionsGroup;
use AppOld\OldOption;
use Illuminate\Database\Seeder;

class HotelOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $ar = unserialize('a:3:{s:2:"ru";s:32:"0KHQv9C+0YDRgiDQuCDQntGC0LTRi9GF";s:2:"en";s:0:"";s:2:"ka";s:0:"";}');
//        dd(base64_decode($ar['ru']));
//        $optionObject = Option::where('category', 1)->get();
//        foreach ($optionObject as $obj) {
//            dump($obj->unser('ml_title'));
//        }
//        dd();
        $this->hotelOptions();
        $this->roomOptions();

    }

    public function hotelOptions()
    {
        $optionObject = OldOption::where('category', 1)->get();

        foreach ($optionObject as $obj) {
//            dump($obj->unser('ml_title'));
//            dump($obj->category);
            $var['ml_title'] = $obj->unser('ml_title');

            $newHotelOptGroup = new OptionsGroup();
            $newHotelOptGroup->hotels = true;

            $newHotelOptGroup->fill([
                'ru' => [
                    'title' => trim($var['ml_title']['ru'])
                ],
                'ge' => [
                    'title' => !empty($var['ml_title']['ka']) ? trim($var['ml_title']['ka']) : '',
                ]
            ]);
            $newHotelOptGroup->save();

            $subList = $obj->subList()->get();
            foreach ($subList as $opt) {
                $sVar = [];
                $sVar['ml_title'] = $opt->unser('ml_title');

                $hotelOption = new Option();
                $hotelOption->fill([
                        'ru' => [
                            'title' => trim($sVar['ml_title']['ru'])
                        ],
                        'ge' => [
                            'title' => !empty($sVar['ml_title']['ka']) ? trim($sVar['ml_title']['ka']) : '',
                        ]
                    ]
                );

                $newHotelOptGroup->options()->save($hotelOption);
            }
//            $optionObject = \AppOld\OptionsSublist::all();
//            foreach ($subList as $obj) {
//                dump($obj->unser('ml_title'));
//            }
        }
    }

    public function roomOptions()
    {
        $optionObject = OldOption::where('category', 6)->get();

        foreach ($optionObject as $obj) {
//            dump($obj->unser('ml_title'));
//            dump($obj->category);
            $var['ml_title'] = $obj->unser('ml_title');

            $newHotelOptGroup = new OptionsGroup();
            $newHotelOptGroup->rooms = true;
            $newHotelOptGroup->fill([
                'ru' => [
                    'title' => trim($var['ml_title']['ru'])
                ],
                'ge' => [
                    'title' => !empty($var['ml_title']['ka']) ? trim($var['ml_title']['ka']) : '',
                ]
            ]);
            $newHotelOptGroup->save();

            $subList = $obj->subList()->get();
            foreach ($subList as $opt) {
                $sVar = [];
                $sVar['ml_title'] = $opt->unser('ml_title');

                $hotelOption = new Option();
                $hotelOption->fill([
                        'ru' => [
                            'title' => trim($sVar['ml_title']['ru'])
                        ],
                        'ge' => [
                            'title' => !empty($sVar['ml_title']['ka']) ? trim($sVar['ml_title']['ka']) : '',
                        ]
                    ]
                );

                $newHotelOptGroup->options()->save($hotelOption);
            }
        }
    }
}
