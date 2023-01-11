<?php

use App\Place;
use AppOld\ObjectModel;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $placesArray = [];
        $objects = ObjectModel::where('category', 2)->get();
        foreach ($objects as $city) {
            $var = [];

//            dump($this->unser($city->ml_title));
            $var['ml_title'] = $city->unser('ml_title');
//            $var['ml_intro'] = $this->unser($city->ml_intro);
//            $var['ml_data'] = $this->unser($city->ml_data);
//            $var['ml_page_name'] = $this->unser($city->ml_page_name);
//            $var['ml_page_title'] = $this->unser($city->ml_page_title);
//            $var['ml_page_kw'] = $this->unser($city->ml_page_kw);
//            $var['ml_page_description'] = $this->unser($city->ml_page_description);

            $placesGroup = new \App\PlacesGroup();
            $placesGroup->fill([
                'ru' => ['name' => $var['ml_title']['ru']],
                'ge' => ['name' => !empty($var['ml_title']['ka']) ? $var['ml_title']['ka'] : null]
            ]);
            $placesGroup->save();

            $placesArray[$var['ml_title']['ru']] = $placesGroup->id;
        }

        $objects = ObjectModel::where('category', 8)->get();
        foreach ($objects as $city) {
            $var = [];

//            dump($this->unser($city->ml_title));
            $var['ml_title'] = $city->unser('ml_title');
            $var['ml_intro'] = $city->unser('ml_intro');
            $var['ml_data'] = $city->unser('ml_data');
            $var['ml_page_name'] = $city->unser('ml_page_name');
            $var['ml_page_title'] = $city->unser('ml_page_title');
            $var['ml_page_kw'] = $city->unser('ml_page_kw');
            $var['ml_page_description'] = $city->unser('ml_page_description');

            $direction = ObjectModel::find($city->direction);


            $place = new Place();
            if ($direction) {
                $place->places_group_id = $placesArray[$direction->unser('ml_title')['ru']];
            }
            $place->slug = str_slug($var['ml_title']['ru']);
            $place->fill([
                'ru' => [
                    'name' => $var['ml_title']['ru'],
                    'page' => $var['ml_data']['ru'],
                    'meta_keywords' => $var['ml_page_kw']['ru']
                ],
                'ge' => [
                    'name' => !empty($var['ml_title']['ka']) ? $var['ml_title']['ka'] : '',
                    'page' => !empty($var['ml_data']['ka']) ? $var['ml_data']['ka'] : '',
                    'meta_keywords' => !empty($var['ml_page_kw']['ka']) ? $var['ml_page_kw']['ka'] : ''
                ]
            ]);
            $place->save();
            dump($place->name);
            $ids = $this->saveImages($city);
            $place->images()->sync($ids);

        }

//        dd($objects->toArray());
    }

    public function saveImages(AppOld\ObjectModel $object)
    {
        $imagesIds = [];

        foreach ($object->attachedGallery as $remoteImage) {

//            $url = 'https://sunnygeorgia.travel/uploads/attached_gallery/' . $remoteImage->file;
            $url = 'https://s3.eu-central-1.amazonaws.com/sunny-geo-old/' . $remoteImage->file;

            try {
                $contents = file_get_contents($url);

                $image = ImageLib::make($contents);
                $imageNormal = $image->resize(840, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imageNormal = $imageNormal->stream();

                $name = substr($url, strrpos($url, '/') + 1);
                $t = Storage::cloud()->put('original/1/' . $name, $imageNormal->__toString(), 'public');

//                $t = Storage::disk('s3')->put('thumb/1/' . $name, $imageNormal->__toString());
                $imageNamePath = Storage::cloud()->url('original/1/' . $name);
                if ($t) {
                    $image = new \App\Media();
                    $image->name = $name;
                    $image->url = $imageNamePath;
                    $image->user_id = 0;
                    $image->save();

                    $imagesIds[] = $image->id;
                }
            } catch (Exception $e) {
                dump($e->getMessage());
                continue;
            }
        }
        return $imagesIds;
    }
}
