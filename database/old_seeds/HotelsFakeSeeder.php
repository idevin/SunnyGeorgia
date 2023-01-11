<?php

use Illuminate\Database\Seeder;

class HotelsFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {

            $hotel = new \App\Models\Hotels\Hotel();
            $hotel->user_id = 1;
//            $hotel->thumb_id = null;
            $hotel->price = $faker->randomFloat(2, 1, 1000);
            $hotel->published = $faker->boolean();
            $hotel->type = 'hotel';
            $hotel->in_time = '15:00';
            $hotel->out_time = '12:00';
            $hotel->phone = $faker->phoneNumber;

            $hotel->fill([
                'en' => [
                    'title' => $faker->company,
                    'intro' => $faker->text,
                    'description' => $faker->text
                ],
                'ge' => [
                    'title' => $faker->company,
                    'intro' => $faker->text,
                    'description' => $faker->text
                ],
                'ru' => [
                    'title' => $faker->company,
                    'intro' => $faker->text,
                    'description' => $faker->text
                ],
            ]);

            $hotel->save();


            $image = new \App\Media();
            $image->user_id = 1;
            $image->name = $faker->word();
            $image->url = $faker->imageUrl();
            $image->save();

            $hotel->thumb_id = $image->id;
            $hotel->save();

            $imageIds = [];
            for ($b = 0; $b < 10; $b++) {
                $image = new \App\Media();
                $image->user_id = 1;
                $image->name = $faker->word();
                $image->url = $faker->imageUrl();
                $image->save();
                $imageIds[] = $image->id;
            }

            $hotel->images()->sync($imageIds);
        }

    }
}
