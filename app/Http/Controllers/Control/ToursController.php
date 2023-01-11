<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\MediaLibrary;
use App\Models\Tours\Accommodation;
use App\Models\Tours\AccommodationAvailability;
use App\Models\Tours\Tour;
use App\Models\Tours\TourFoodOption;
use App\Models\Tours\TourType;
use App\OptionsGroup;
use App\PlacesGroup;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ToursController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search_title = $request->input("search_title");
            $search_email = $request->input("search_email");
            $search_place_id = $request->input("search_place_id");
            $not_published = $request->has("not_published");
            $not_reviewed = $request->has("not_reviewed");
            $with_trashed = $request->has("with_trashed");
            $order = explode("__", $request->input('order', "updated_at__desc"));
            $tours = Tour::whereHas('translations', function ($query) use ($search_title) {
                $query->where("title", "LIKE", "%$search_title%");
            })->whereHas('place', function ($query) use ($search_place_id) {
                if ($search_place_id)
                    $query->where("id", $search_place_id);
            })
                ->whereHas('user', function ($query) use ($search_email) {
                    $query->where("email", "LIKE", "%$search_email%");
                })
                ->when($not_published, function ($query) use ($not_published) {
                    return $query->where('published', !$not_published);
                })
                ->when($not_reviewed, function ($query) use ($not_reviewed) {
                    return $query->where('reviewed', !$not_reviewed);
                })
                ->with('translations', 'place', 'place.translations', 'accommodations', 'accommodations.translations', 'user')
                ->withTrashed($with_trashed)
                ->orderBy($order[0], $order[1])
                ->paginate(25);

            return response()->json($tours);
        }

        $tours = [];
        //$tours = Tour::orderBy('id')->with('translations', 'place', 'place.translations', 'accommodations', 'accommodations.translations', 'user')->paginate(25);
        $placesGroups = PlacesGroup::with('places')->get()->toJson();
        $users = User::has('tours')->get()->toJson();
        $fields = collect(['id', 'Дата', 'Владелец', 'Картинка', 'Город', 'Вес', 'Заголовок'])->toJSON();
        return view('control.tours.index', compact('tours', 'placesGroups', 'users', 'fields'));

        //return view('control.tours.index', compact('tours'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tour = Tour::findOrFail($id)
            ->makeVisible(['commission', 'commission_proposal'])
            ->makeHidden('minPrice');
        $tour->load(
            'options',
            'options.translations',
            'priceOptions',
            'parts',
            'place',
            'places',
            'places.translations',
            'translations',
            'foodOption'
        );
        $optionGroups = OptionsGroup::where('tours', true)
            ->with('translations', 'optionsCollection', 'optionsCollection.translations')
            ->get();
        $tour->options = $tour->options->keyBy('id');
        $users = User::all();
        $tour->load('user', 'ribbon');
        $foodOptions = TourFoodOption::with('translations')->get();
        $tourTypes = TourType::with('translations')->get();
        $currentTourTypesIds = $tour->types->pluck('id');
        $gallery = [];
        foreach ($tour->getMedia('tours') as $index => $item) {
            $gallery[] = [
                'url' => $item->getUrl(),
                'id' => $item->id,
                'alt' => $item->getCustomProperty('alt') ?? null,
                'mainImage' => $item->getCustomProperty('main') ?? null,
            ];
        }
        return view(
            'control.tours.edit',
            compact(
                'tour',
                'optionGroups',
                'users',
                'foodOptions',
                'tourTypes',
                'currentTourTypesIds',
                'gallery'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'start_place_id' => 'exists:places,id',
            'options' => 'array',
            'places' => 'array',
            'user_id' => 'exists:users,id',
        ]);

        $tour = Tour::findOrFail($id);
        $tour->fill($request->all());

        $tour->places()->sync($request->input('places', []));

        $tour = $this->setPriceOptions($request->input('price_options', []), $tour);
        $tour = $this->setTourParts($request->input('parts', []), $tour);

        $tour->save();
        $tour->types()->sync($request->input('types', []));

        $this->setMedia($request->input('images', []), $request->input('main_image', null));

        return response()->json(['success' => true, 'tour' => $tour]);
    }

    protected function setPriceOptions($priceOptions, $tour)
    {
        $tour->priceOptions->each(function ($el) {
            $el->delete();
        });
        foreach ($priceOptions as $option) {
            $data = ['included' => $option['included']];
            foreach ($option['translations'] as $translation) {
                $data['name:' . $translation['locale']] = $translation['name'] ?? '';
            }
            $tour->priceOptions()->create($data);
        }
        return $tour;
    }

    protected function setTourParts($tourParts, $tour)
    {
        $tour->parts->each(function ($el) {
            $el->delete();
        });
        foreach ($tourParts as $part) {
            $data = ['day_order' => $part['day_order']];
            foreach ($part['translations'] as $translation) {
                $data['name:' . $translation['locale']] = $translation['name'] ?? '';
                $data['title:' . $translation['locale']] = $translation['title'] ?? '';
                $data['description:' . $translation['locale']] = $translation['description'] ?? '';
            }
            $tour->parts()->create($data);
        }
        return $tour;
    }

    private function setMedia(Array $images, $mainImage)
    {
        foreach ($images as $image) {
            $mediaItem = MediaLibrary::find($image['id']);

            if (isset($image['alt'])) {
                $mediaItem->setCustomProperty('alt', $image['alt']);
            } else {
                $mediaItem->forgetCustomProperty('alt');
            }

            if ($image['id'] === $mainImage) {
                $mediaItem->setCustomProperty('main', true);
            } else {
                $mediaItem->forgetCustomProperty('main');
            }

            $mediaItem->save();
        }
    }

    public function delete($id)
    {
        $result = Tour::destroy($id);
        return redirect()->route('control:tours.index', ['success' => $result]);
    }

    public function accommodation($tourId)
    {
        $tour = Tour::findOrFail($tourId)->load(
            'options',
            'accommodations',
            'accommodations.translations',
            'accommodations.currency',
            'place'
        );
        $acom = $tour->accommodations;
        $hotels = $acom->keyBy('hotel')->keys()->toArray();
        $rooms = $acom->keyBy('room')->keys()->toArray();
        if (count($rooms) == 0)
            $doprooms = ["SGL", "DBL", "TRPL"];

        for ($i = count($rooms) + 1; $i <= 3; $i++) {
            $_droom = (isset($doprooms)) ? $doprooms[$i - 1] : "room_" . $i;
            $rooms[] = in_array($_droom, $rooms) ? $_droom . '*' : $_droom;
        }
        for ($i = count($hotels) + 1; $i <= 5; $i++) {
            $_dhotel = "hotel_" . ($i + 2) . "*";
            $hotels[] = (in_array($_dhotel, $hotels)) ? $_dhotel . '*' : $_dhotel;
        }
        return view(
            'control.tours.accommodation',
            compact('tour', 'acom', 'hotels', 'rooms')
        );
    }

    public function updateAccommodation($tourId, Request $request)
    {
        $tour = Tour::findOrFail($tourId);

        $hotels = $request->input('hotels');
        if (count($hotels) != count(array_flip($hotels)))
            return back()->with(['status' => 'error', 'msg' => 'Hotels - Duplicate name!']);


        $rooms = $request->input('rooms');
        if (count($rooms) != count(array_flip($rooms)))
            return back()->with(['status' => 'error', 'msg' => 'Rooms - Duplicate name!']);

        $acoms = $request->input('acoms');

        $_acoms = [];

        foreach ($hotels as $n => $hotel) {
            foreach ($rooms as $m => $room) {
                if (isset($acoms[$n][$m]['id']) && !isset($acoms[$n][$m]['price_adult']))
                    Accommodation::find($acoms[$n][$m]['id'])->delete();
                if (isset($acoms[$n][$m]['price_adult']))
                    $_acoms[] = [
                        "id" => $acoms[$n][$m]['id'],
                        "hotel" => $hotel,
                        "room" => $room,
                        "adults" => $acoms[$m]['adults'],
                        "price_adult" => $acoms[$n][$m]['price_adult'],
                        "price_additional" => $acoms[$n]['price_additional'],
                        "price_kid" => $acoms[$n]['price_kid'],
                    ];

            }
        }

        foreach ($_acoms as $key => $acom) {
            $accommodation = isset($acom['id']) ? Accommodation::find($acom['id']) : new Accommodation();
            $accommodation->fill($acom);
            $tour->accommodations()->save($accommodation);
        }

        return back()->with(['status' => 'success', 'msg' => 'Accommodations saved!']);
    }

    public function postAccommodation($tourId, Request $request)
    {
        $tour = Tour::findOrFail($tourId);
        $this->validate($request, [
            'acom.*.hotel' => 'required',
            'acom.*.room' => 'required',
            'acom.*.adults' => 'required',
//            'acom.*.kids' => 'required'
        ]);


        foreach ($request->input('acom') as $key => $acom) {
            $newAccommodation = new Accommodation();
            $newAccommodation->fill($acom);
            $tour->accommodations()->save($newAccommodation);
        }
        return back()->with(['status' => 'success', 'msg' => 'Accommodations saved!']);
    }

    public function postAccommodationAvailabilityModal($tourId, Request $request)
    {
        $tour = Tour::findOrFail($tourId);
        $this->validate($request, [
//            'accommodations.*' => 'required|exists:accommodations,id',
            'accommodations' => 'array',
            'accommodations.*' => 'required',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'amount' => 'required|integer'
        ]);

        $weekDays = array_keys($request->input('day_of_week', []));

        $dateTo = Carbon::parse($request->input('date_to'))->startOfDay();

        $accoms = Accommodation::whereIn('id', $request->input('accommodations', []))->get();

        $tour->availability->each(function ($el) {
            $el->delete();
        });

        foreach ($accoms as $acom) {
            for ($dateFrom = Carbon::parse($request->input('date_from'))->startOfDay(); $dateTo->diffInDays($dateFrom, false) <= 0; $dateFrom->addDay()) {
                if (!in_array($dateFrom->dayOfWeek, $weekDays)) {
                    continue;
                }
                $data = [
                    'accommodation_id' => $acom->id,
                    'date' => $dateFrom->toDateString(),
                    'amount' => (int)$request->input('amount'),
                    'discount_percent' => (float)$request->input('discount', 0),
                    'price_special_gel' => (float)$request->input('price', 0),
                ];
                AccommodationAvailability::updateOrCreate([
                    'date' => $dateFrom->toDateString(),
                    'accommodation_id' => $acom->id
                ], $data);
            }
        }

        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function postAccommodationAvailabilityForm(Request $request)
    {
        $this->validate($request, [
            'availability.*' => 'required'
        ]);

        foreach ($request->input('availability') as $acomId => $dates) {
            foreach ($dates as $date => $amount) {
                $dateFrom = Carbon::parse($date)->startOfDay();
                //todo check https://laravel.com/docs/9.x/upgrade#belongs-to-many-first-or-new
                AccommodationAvailability::updateOrCreate([
                    'date' => $dateFrom->toDateString(),
                    'accommodation_id' => $acomId
                ], [
                    'accommodation_id' => $acomId,
                    'date' => $dateFrom->toDateString(),
                    'amount' => (int)$amount,
                ]);
            }
        }
        return back()->with(['success' => 'Updated']);
    }

    public function deleteAccommodation($tourId, $accommName)
    {
        $tour = Tour::findOrFail($tourId);
        $tour->accommodations()->whereTranslation('hotel', $accommName)->delete();
        return back();
    }

    public function calendar($tourId, Request $request)
    {
        $yearMin = date('Y') - 1;
        $yearMax = $yearMin + 20;

        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        $tour = Tour::findOrFail($tourId)->load('accommodations', 'accommodations.translations');
        $accommodations = $tour->accommodations;
        $availabilities = [];
        $date = Carbon::create($year, $month, 1, 0, 0, 0)->startOfMonth();
        $amountDaysInMonth = $date->format('t');

        foreach ($accommodations as $acom) {
            $availabilities[$acom->id] = $acom->available($date, (clone($date))->endOfMonth())->get()->keyBy('date');
        }

        return view('control.tours.calendar',
            compact(
                'tour',
                'accommodations',
                'date',
                'amountDaysInMonth',
                'availabilities'
            )
        );
    }

    public function updateModeratorData($tourId, Request $request)
    {
        $this->validate($request, [
            'slug:ru' => 'required',
        ]);
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
            $request['slug:' . $language] = $request->input('slug:' . $language) ?
                str_slug($request['slug:' . $language]) : null;
            $request['noindex_' . $language] = $request->has('noindex_' . $language);
        }
        $tour = Tour::findOrFail($tourId);
        $tour->fill(
            $request->all()
        );
        if ($request->has('ribbon_id')) {
            if ($request->filled('ribbon_id')) {
                $tour->ribbon()->associate($request->input('ribbon_id'));
            } else {
                $tour->ribbon()->dissociate();;
            }
        }
        if ($request->has('reviewed')) {
            $tour->reviewed = $request->input('reviewed');
        }
        if ($request->has('user_id')) {
            $tour->user_id = $request->input('user_id');
        }
        $tour->save();
        return back()->with(['status' => 'success', 'msg' => 'Настройки тура сохранены']);
    }
}
