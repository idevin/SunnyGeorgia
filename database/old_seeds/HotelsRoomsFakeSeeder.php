<?php

use Illuminate\Database\Seeder;

class HotelsRoomsFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $hotels = \App\Models\Hotels\Hotel::all();
        foreach ($hotels as $hotel) {
            $rooms = 0;
            $avaDates = 0;

            dump('Hotel id: ' . $hotel->id);

            for ($i = 0; $i < rand(1, 8); $i++) {


                $roomModel = new \App\Models\Hotels\Room();
                $roomModel->amount = rand(1, 100);
                $roomModel->area = $faker->randomFloat(2, 5, 100);
                $roomModel->thumb_id = null;
                $roomModel->price = $faker->randomFloat(2, 20, 1000);;
                $roomModel->published = $faker->boolean();
                $roomModel->title = '';//?????
                $roomModel->adults = rand(1, 10);//?????
                $roomModel->kids = rand(1, 10);//?????

                if ($faker->boolean(95)) {
                    $image = new \App\Media();
                    $image->user_id = 1;
                    $image->name = $faker->word();
                    $image->url = $faker->imageUrl();
                    $image->save();

                    $roomModel->thumb_id = $image->id;
                }
                $hotel->rooms()->save($roomModel);

                $carbonCurrent = \Carbon\Carbon::now()->addDay()->startOfDay();
                $carbonFuture = \Carbon\Carbon::now()->addYear()->startOfDay();

                while ($carbonCurrent->diffInDays($carbonFuture, false) > 0) {
                    $available = $faker->boolean(80);
                    if ($available) {

                        $roomAvailability = new \App\Models\Hotels\RoomsAvailability();
                        $roomAvailability->date = $carbonCurrent->toDateString();
                        $roomAvailability->amount = rand(1, $roomModel->amount);
                        $roomAvailability->available = true;
                        $roomAvailability->days_cancel = rand(1, 14);
                        $roomAvailability->days_book_min = rand(1, 3);
                        $roomAvailability->price_special = $faker->randomFloat(2, $roomModel->price / 2, $roomModel->price);
                        $roomAvailability->discount_percent = (($roomModel->price - $roomAvailability->price_special) / $roomModel->price) * 100;

                        $roomModel->availability()->save($roomAvailability);
                        $avaDates++;
                    }

//                    dump($carbonCurrent->diffInDays($carbonFuture, false));
//                    dump($carbonCurrent->toDateString());
                    $carbonCurrent->addDay();
                }
                $rooms++;
            }
            dump('rooms ' . $rooms);
            dump('avail ' . $avaDates);
        }
    }
}
