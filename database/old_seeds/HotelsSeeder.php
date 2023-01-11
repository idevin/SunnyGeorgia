<?php

use App\Models\Hotels\Hotel;
use App\Media;
use App\Models\Hotels\Room;
use App\User;
use AppOld\ObjectModel;
use Illuminate\Database\Seeder;

class HotelsSeeder extends Seeder
{
    public $optionList;

    public function __construct()
    {
        $this->optionList = \App\Option::all()->pluck('id', 'title');
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

        $hotels = ObjectModel::where('category', 1)->with('uniqueParam', 'subOptions', 'user')->get();
        foreach ($hotels as $hotelObject) {

            $var['ml_title'] = $hotelObject->unser('ml_title');
            $var['ml_intro'] = $hotelObject->unser('ml_intro');
            $var['ml_data'] = $hotelObject->unser('ml_data');
            $var['ml_page_name'] = $hotelObject->unser('ml_page_name');
            $var['ml_page_title'] = $hotelObject->unser('ml_page_title');
            $var['ml_page_kw'] = $hotelObject->unser('ml_page_kw');
            $var['ml_page_description'] = $hotelObject->unser('ml_page_description');


            $userId = 0;
            $user = null;
            if (!empty($hotelObject->user)) {
                if (!empty($hotelObject->user->email)) {
                    $user = User::where('email', $hotelObject->user->email)->first();
                } elseif (!empty($hotelObject->user->user_name)) {
                    $user = User::where('first_name', $hotelObject->user->user_name)->first();
                }

                if ($user) {
                    $userId = $user->id;
                } else {
                    dump('user not found', $hotelObject->user_id);
                }
            }

            $newHotel = new Hotel();
            $newHotel->user_id = $userId;

            //Get place
            $direction = ObjectModel::find($hotelObject->town);
            if ($direction) {
                $newHotel->place_id = $placesArray[$direction->unser('ml_title')['ru']];
            } else {
                $newHotel->place_id = 0;
            }

            $params = $hotelObject->uniqueParam;
            foreach ($params as $paramObject) {
                switch ($paramObject->param_name) {
                    case ('go_in'):
                        $newHotel->in_time = trim($paramObject->param_text_value);
                        break;
                    case ('go_out'):
                        $newHotel->out_time = trim($paramObject->param_text_value);
                        break;
                    case ('address'):
                        $newHotel->address = trim($paramObject->param_text_value);
                        break;
                    case ('mobile'):
                        $newHotel->mobile = trim($paramObject->param_text_value);
                        break;
                    case ('phone'):
                        $newHotel->phone = trim($paramObject->param_text_value);
                        break;
                    case ('email'):
                        $newHotel->email = trim($paramObject->param_text_value);
                        break;
                }
            }
//            dd($params->toArray());


            $newHotel->published = $hotelObject->publish;

            //fill page
            $newHotel->fill(
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
            $newHotel->save();
            dump($newHotel->title);



            $ids = $this->saveImages($hotelObject, $user);
            $newHotel->images()->sync($ids);

            //SAVING HOTEL OPTIONS
            $options = [];
            $subOption = $hotelObject->subOptions;
            foreach ($subOption as $opt) {

                if (isset($this->optionList[trim($opt->unser('ml_title')['ru'])])) {
                    $options[] = $this->optionList[trim($opt->unser('ml_title')['ru'])];
                }
            }
            if (!empty($options)) {
                $newHotel->options()->sync($options, ['value' => '']);
//                dump('hotel: ' . $newHotel->title, $options);
            }
            ///////////////////////
            $newHotel->slug = $newHotel->id . '-' . str_slug($var['ml_title']['ru']);
            $newHotel->save();

            $this->room($newHotel->id, $hotelObject->id);
//            dump($var);
//            dd($hotelObject->toArray());
        }


    }

    public function room($newHotelId, $hotelObjectId, User $user = null)
    {
        $roomsObject = ObjectModel::where('category', 6)->where('hotel', $hotelObjectId)->with('uniqueParam', 'subOptions')->get();

        if (!$roomsObject->isEmpty()) {
            foreach ($roomsObject as $roomObject) {

                $var = [];
                $var['ml_title'] = $roomObject->unser('ml_title');
                $var['ml_intro'] = $roomObject->unser('ml_intro');
                $var['ml_data'] = $roomObject->unser('ml_data');
                $var['ml_page_name'] = $roomObject->unser('ml_page_name');
                $var['ml_page_title'] = $roomObject->unser('ml_page_title');
                $var['ml_page_kw'] = $roomObject->unser('ml_page_kw');
                $var['ml_page_description'] = $roomObject->unser('ml_page_description');


                $newRoom = new Room();
                $newRoom->hotel_id = $newHotelId;
                $newRoom->amount = (int)$roomObject->qty;
                $newRoom->price = (int)$roomObject->price;

                $params = $roomObject->uniqueParam;
                foreach ($params as $paramObject) {
                    switch ($paramObject->param_name) {
                        case ('area'):
                            $newRoom->area = (double)$paramObject->param_text_value;
                            break;
                        case ('children'):
                            $newRoom->kids = (int)$paramObject->param_text_value;
                            break;
                        case ('growns'):
                            $newRoom->adults = (int)$paramObject->param_text_value;
                            break;

                    }
                }
                $newRoom->title = trim($var['ml_title']['ru']);
                $newRoom->save();

                $ids = $this->saveImages($roomObject, $user);
                $newRoom->images()->sync($ids);

                //SAVING ROOM OPTIONS
                $options = [];
                $subOption = $roomObject->subOptions;
                foreach ($subOption as $opt) {
                    if (isset($this->optionList[trim($opt->unser('ml_title')['ru'])])) {

                        $options[] = $this->optionList[trim($opt->unser('ml_title')['ru'])];
                    }
                }
                if (!empty($options)) {
                    $newRoom->options()->sync($options);
                    dump('room', $options);
                }
                ///////////////////////

                //fill page
//                $newRoom->fill(
//                    [
//                        'ru' => [
//                            'title' => $var['ml_title']['ru'],
//                            'intro' => $var['ml_intro']['ru'],
//                            'description' => $var['ml_data']['ru']
//                        ],
//                        'ge' => [
//                            'title' => !empty($var['ml_title']['ka']) ? $var['ml_title']['ka'] : '',
//                            'intro' => !empty($var['ml_intro']['ka']) ? $var['ml_intro']['ka'] : '',
//                            'description' => !empty($var['ml_data']['ka']) ? $var['ml_data']['ka'] : ''
//                        ]
//                    ]
//                );
            }

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
