<?php

use App\Media;
use App\Models\Excursions\Excursion;
use App\User;
use AppOld\ObjectModel;
use Illuminate\Database\Seeder;

class ExcursionsSeeder extends Seeder
{
    public $optionsList;

    public function __construct()
    {
        $this->optionsList = \App\Option::all()->pluck('id', 'title');

    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        App::setLocale('ru');
        $places = \App\Place::with('translations')->get();
        $placesArray = [];
        foreach ($places as $place) {
            $placesArray[$place->translate()->name] = $place->id;
        }

        $hotels = ObjectModel::where('category', 5)->with('uniqueParam', 'subOptions')->get();
        foreach ($hotels as $excObject) {


            $var['ml_title'] = $excObject->unser('ml_title');
            $var['ml_intro'] = $excObject->unser('ml_intro');
            $var['ml_data'] = $excObject->unser('ml_data');
            $var['ml_page_name'] = $excObject->unser('ml_page_name');
            $var['ml_page_title'] = $excObject->unser('ml_page_title');
            $var['ml_page_kw'] = $excObject->unser('ml_page_kw');
            $var['ml_page_description'] = $excObject->unser('ml_page_description');

            if (!empty($excObject->user)) {
                if (!empty($excObject->user->email)) {
                    $user = User::where('email', $excObject->user->email)->first();
                } elseif (!empty($excObject->user->user_name)) {
                    $user = User::where('first_name', $excObject->user->user_name)->first();
                }

                if ($user) {
                    $userId = $user->id;
                } else {
                    dump('user not found', $excObject->user_id);
                }
            }

            $newExcursion = new Excursion();
            $newExcursion->published = true;
            $newExcursion->reviewed = true;
            $newExcursion->user_id = $userId;
            $newExcursion->price_excursion = $excObject->price;

            //Get place
            $direction = ObjectModel::find($excObject->town);
            if ($direction) {
                $newExcursion->place_id = $placesArray[$direction->unser('ml_title')['ru']];
            } else {
                $newExcursion->place_id = 0;
            }

            $params = $excObject->uniqueParam;
            foreach ($params as $paramObject) {
                switch ($paramObject->param_name) {
                    case ('num_pepole'):
                        $newExcursion->min_people = trim($paramObject->param_text_value);
                        break;
                    case ('max_pepole'):
                        $newExcursion->max_people = (int)trim($paramObject->param_text_value) > 0 ? (int)$paramObject->param_text_value : null;
                        break;
                    case ('excursion_time'):
                        $newExcursion->duration = (double)trim($paramObject->param_text_value);
                        break;
                    case ('exc_price_person'):
//                        $newExcursion->price_per_person = trim($paramObject->param_text_value) == 1 ? true : false;
                        if (trim($paramObject->param_text_value) == 1) {
                            $newExcursion->price_adult = $excObject->price;
                            $newExcursion->price_excursion = null;
                        }
                        break;

                }
            }
//            dump($newExcursion->place_id);
//            dd($excObject->toArray());


            $newExcursion->published = $excObject->publish;

            //fill page
            $newExcursion->fill(
                [
                    'ru' => [
                        'title' => trim($var['ml_title']['ru']),
                        'intro' => trim($var['ml_intro']['ru']),
                        'description' => trim($var['ml_data']['ru'])
                    ],
                    'ge' => [
                        'title' => !empty($var['ml_title']['ka']) ? trim($var['ml_title']['ka']) : '',
                        'intro' => !empty($var['ml_intro']['ka']) ? trim($var['ml_intro']['ka']) : '',
                        'description' => !empty($var['ml_data']['ka']) ? trim($var['ml_data']['ka']) : ''
                    ]
                ]
            );
            $newExcursion->save();


            $ids = $this->saveImages($excObject, $user);

            $newExcursion->images()->sync($ids);

            //SAVING HOTEL OPTIONS
            $options = [];
            $subOption = $excObject->subOptions;
            foreach ($subOption as $opt) {

                if (isset($this->optionsList[trim($opt->unser('ml_title')['ru'])])) {
                    $options[] = $this->optionsList[trim($opt->unser('ml_title')['ru'])];
                }
            }
            if (!empty($options)) {
                $newExcursion->options()->sync($options, ['value' => '']);
                dump('Excursion: ' . $newExcursion->title, $options);
            }
            ///////////////////////
            $newExcursion->slug = $newExcursion->id . '-' . str_slug($var['ml_title']['ru']);
            $newExcursion->save();

        }

    }

    public function saveImages(AppOld\ObjectModel $object, User $user = null)
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
                $name = strtolower($name);
                $path = 'original/' . (!empty($user->id) ? $user->id : 0) . '/' . $name;

                $t = Storage::cloud()->put($path, $imageNormal->__toString(), 'public');

//                $t = Storage::disk('s3')->put('thumb/1/' . $name, $imageNormal->__toString());
                $imageNamePath = Storage::cloud()->url($path);
                if ($t) {
                    $image = new Media();
                    $image->name = $name;
                    $image->url = $imageNamePath;
                    $image->user_id = !empty($user->id) ? $user->id : 0;
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
