<?php

use App\Models\Tours\Accommodation;
use App\Models\Tours\AccommodationAvailability;
use App\Role;
use App\OptionsGroup;
use App\User;
use Illuminate\Database\Seeder;

class ToursFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fakerEn = Faker\Factory::create();
        $fakerGe = Faker\Factory::create('ka_GE');
        $fakerRu = Faker\Factory::create('ru_RU');

        $optionsGroups = OptionsGroup::whereTours(true)->with('options')->get();


        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'partner');
        })->get();

        $usersIds = $users->pluck('id')->toArray();
        $places = \App\Place::all();
        $placesIds = $places->pluck('id')->toArray();

        $currencies = Currency::all();
        $currenciesIds = collect($currencies)->pluck('id')->toArray();

        for ($i = 0; $i < 1000; $i++) {
            echo '*';
            $tour = new \App\Models\Tours\Tour();
            $tour->user_id = $usersIds[array_rand($usersIds, 1)];
            $tour->start_place_id = $placesIds[array_rand($placesIds, 1)];
            $tour->calendar_use = true; ///????????

            $tour->flight_included = rand(0, 1);
            $tour->flight_price = rand(0, 1) ? rand(0, 500) : null;
            $tour->flight_currency = $tour->flight_price ? $currenciesIds[array_rand($currenciesIds, 1)] : null;
            $tour->transfer_included = rand(0, 1);
            $tour->transfer_price = rand(0, 1) ? rand(0, 100) : null;
            $tour->transfer_currency = $tour->transfer_price ? $currenciesIds[array_rand($currenciesIds, 1)] : null;
//            $tour->min_people = rand(1,10);
//            $tour->max_people = rand(1,10);
            $tour->days = rand(1, 100);
            $tour->nights = $tour->days - 1;
            $tour->reviewed = true;
            $tour->published = true;
//            $tour->adults = '';
//            $tour->children = '';

            $ruTitle = $fakerRu->text(200);


            $tour->fill([
                'en' => [
                    'title' => $fakerEn->realText(255),
                    'intro' => $fakerEn->realText,
                    'description' => $fakerEn->realText
                ],
                'ge' => [
                    'title' => $this->clear($fakerGe->realText(200)),
                    'intro' => $this->clear($fakerGe->realText),
                    'description' => $this->clear($fakerGe->realText)
                ],
                'ru' => [
                    'title' => $this->clear($ruTitle),
                    'intro' => $this->clear($fakerRu->realText),
                    'description' => $this->clear($fakerRu->realText)
                ],
            ]);

            $tour->save();
            $tour->slug = $tour->id . '-' . str_slug($ruTitle);
            $tour->save();

            $tour->refresh();

            //options section
            $options = [

            ];
            foreach ($optionsGroups as $groupItem) {
                foreach ($groupItem->options()->get() as $opt) {

                    if (rand(0, 1)) continue;

                    echo '+';
                    if ($groupItem->price) {
                        $free = rand(0, 1) ? true : false;
                        $options[$opt->id] = [
                            'free' => $free,
                            'price' => $free ? null : rand(1, 100)
                        ];
                    } else {
                        $options[$opt->id] = $opt->id;
                    }
                }
            }


            $tour->options()->sync($options);
            ////

            $tour->places()->sync(array_rand($places->pluck('name', 'id')->toArray(), rand(1, 10)));

            for ($a = 0; $a < rand(1, 8); $a++) {
                $newAccommodation = new Accommodation();
                $newAccommodation->fill([
                    'tour_id' => $tour->id,
                    'price_adult' => rand(1, 1000),
                    'price_kid' => rand(1, 1000),
                    'price_additional' => rand(1, 1000),
                    'currency_id' => $currenciesIds[array_rand($currenciesIds, 1)],
                    'adults' => rand(1, 8),
                    'kids' => rand(1, 8),
                    'add_beds' => rand(0, 8),
                    'ru' => [
                        'hotel' => $fakerRu->company,
                        'room' => $fakerRu->company
                    ]
                ]);
                $tour->accommodations()->save($newAccommodation);
                $newAccommodation->refresh();

                for ($b = 0; $b < rand(10, 100); $b++) {

                    $dateFrom = \Carbon\Carbon::now()->addDays($b);
                    $data = [
                        'accommodation_id' => $newAccommodation->id,
                        'date' => $dateFrom->toDateString(),
                        'amount' => rand(1, 10),
                        'discount_percent' => 0,
                        'price_special_gel' => null,
                    ];
                    AccommodationAvailability::updateOrCreate([
                        'date' => $dateFrom->toDateString(),
                        'accommodation_id' => $newAccommodation->id
                    ],
                        $data);
                }

            }
        }
    }

    public function clear($text)
    {
        $regex = <<<'END'
/
  (
    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                        # ...one or more times
  )
| .                                 # anything else
/x
END;
        return preg_replace($regex, '$1', $text);
    }
}
