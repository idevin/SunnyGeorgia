<?php

namespace App\Http\Controllers\Cabinet\Partner;

use App\Http\Controllers\Controller;
use App\Models\Tours\Accommodation;
use App\Models\Tours\AccommodationAvailability;
use App\Models\Tours\Tour;
use App\Models\Tours\TourFoodOption;
use App\Models\Tours\TourType;
use App\OptionsGroup;
use App\Partner;
use App\PlacesGroup;
use App\Repositories\MediaRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ToursController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $partner = $user->partner;
        if (empty($partner)) {
            $partner = new Partner();
            $user->partner()->save($partner);
        }

        if ($request->ajax()) {
            $search_title = $request->input("search_title");
            $search_place_id = $request->input("search_place_id");
            $not_published = $request->has("not_published");
            $not_reviewed = $request->has("not_reviewed");
            $with_trashed = $request->has("with_trashed");
            $order = explode("__", $request->input('order', "updated_at__desc"));
            $tours = Tour::query()->where('user_id', Auth::id())
                ->whereHas('translations', function ($query) use ($search_title) {
                    $query->where("title", "LIKE", "%$search_title%");
                })
                ->whereHas('place', function ($query) use ($search_place_id) {
                    if ($search_place_id)
                        $query->where("id", $search_place_id);
                })
                ->when($not_published, function ($query) use ($not_published) {
                    return $query->where('published', !$not_published);
                })
                ->when($not_reviewed, function ($query) use ($not_reviewed) {
                    return $query->where('reviewed', !$not_reviewed);
                })
                ->with('translations', 'place', 'place.translations', 'accommodations', 'accommodations.translations', 'user', 'media')
                ->withTrashed($with_trashed)
                ->orderBy($order[0], $order[1])
                ->paginate(25);

            return response()->json($tours);
        }
        $placesGroups = PlacesGroup::with('places')->get()->toJson();
        //$tours = $user->tours;
        //$tours->load('accommodations', 'accommodations.translations');
        $tours = [];
        $fields = collect(['id', 'Дата', 'Картинка', 'Город', 'Вес', 'Заголовок'])->toJSON();
        return view('cabinet.partner.tours.index', compact(
            'user',
            'partner',
            'tours',
            'placesGroups',
            'fields'
        ));
    }

    public function create()
    {
        $optionGroups = OptionsGroup::query()->where('tours', true)
            ->with('translations', 'optionsCollection', 'optionsCollection.translations')
            ->get();
        $foodOptions = TourFoodOption::with('translations')->get();
        $tourTypes = TourType::with('translations')->get();
        return view('cabinet.partner.tours.create',
            compact(
                'optionGroups',
                'foodOptions',
                'tourTypes'
            ));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ru.title' => 'required',
            'start_place_id' => 'required|exists:places,id',
            'options' => 'array',
            'places' => 'array',
        ]);
        $user = $request->user();

        $tour = new Tour();
        $tour->fill(
            $request->all()
        );
        $tour->reviewed = $user->trusted ? true : false;

        $user->tours()->save($tour);

        $tour->places()->sync($request->input('places', []));

        $tour = $this->setPriceOptions($request->input('price_options', []), $tour);
        $tour = $this->setTourParts($request->input('parts', []), $tour);

        $tour->slug = $tour->id . '-' . str_slug($tour->title);
        $tour->save();

        $tour->types()->sync($request->input('types', []));

        return response()->json([
            'success' => true,
            'tour' => $tour,
            'redirect' => route('cabinet:partner:tours.edit', $tour->id)
        ]);
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

    public function edit($id)
    {
        $tour = Auth::user()->tours()->findOrFail($id)
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
        $foodOptions = TourFoodOption::with('translations')->get();
        $tourTypes = TourType::with('translations')->get();
        $currentTourTypesIds = $tour->types->pluck('id');
        $gallery = [];
        foreach ($tour->getMedia('tours') as $index => $item) {
            $gallery[] = ['url' => $item->getUrl(), 'id' => $item->id];
        }
        return view(
            'cabinet.partner.tours.edit',
            compact(
                'tour',
                'optionGroups',
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
        ]);
        $user = $request->user();
        $tour = $user->tours()->findOrFail($id);
        $tour->fill(
            $request->all()
        );
        $places = $request->input('places', []);
        $tour->places()->sync($places);

        $tour = $this->setPriceOptions($request->input('price_options', []), $tour);
        $tour = $this->setTourParts($request->input('parts', []), $tour);

        $tour->save();
        $tour->types()->sync($request->input('types', []));
        return response()->json(['success' => true, 'tour' => $tour]);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $result = $user->tours()->find($id)->destroy();
        return redirect()->route('cabinet:partner:tours.index', ['success' => $result]);
    }

    public function accommodation($tourId)
    {
        $tour = Auth::user()->tours()->findOrFail($tourId)->load(
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
            'cabinet.partner.tours.accommodation',
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
        $tour = Auth::user()->tours()->findOrFail($tourId);
        $this->validate($request, [
            'acom.*.hotel' => 'required',
            'acom.*.room' => 'required',
            'acom.*.adults' => 'required',
//            'acom.*.kids' => 'required'
        ]);


        foreach ($request->input('acom') as $key => $acom) {
            $acom['currency_id'] = $tour->currency_id;
            $newAccommodation = new Accommodation();
            $newAccommodation->fill($acom);
            $tour->accommodations()->save($newAccommodation);
        }
        return back()->with(['status' => 'success', 'msg' => 'Accommodations saved!']);
    }

    public function postAccommodationAvailabilityModal(Request $request)
    {
        $this->validate($request, [
//            'accommodations.*' => 'required|exists:accommodations,id',
            'accommodations' => 'array',
            'accommodations.*' => 'required',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'amount' => 'required|integer|min:0|max:99999'
        ]);

        $weekDays = array_keys($request->input('day_of_week', []));

        $dateTo = Carbon::parse($request->input('date_to'))->startOfDay();

        $accoms = Accommodation::whereHas('tour', function ($query) {
            $query->where('user_id', Auth::id());
        })->whereIn('id', $request->input('accommodations'))->get();

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

                $amount = (int)$amount;
                $dateFrom = Carbon::parse($date)->startOfDay();
                AccommodationAvailability::updateOrCreate([
                    'date' => $dateFrom->toDateString(),
                    'accommodation_id' => $acomId
                ], [
                    'accommodation_id' => $acomId,
                    'date' => $dateFrom->toDateString(),
                    'amount' => 0 <= $amount && $amount <= 99999 ? $amount : null,
                ]);
            }
        }
        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function deleteAccommodation($tourId, $accommName)
    {
        $tour = Auth::user()->tours()->findOrFail($tourId);
        $tour->accommodations()->whereTranslation('hotel', $accommName)->delete();
        return back();
    }

    public function calendar($tourId, Request $request)
    {
        $yearMin = date('Y') - 1;
        $yearMax = $yearMin + 20;

        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        $tour = Auth::user()->tours()->findOrFail($tourId)->load('accommodations', 'accommodations.translations');
        $accommodations = $tour->accommodations;
        $availabilities = [];
        $date = Carbon::create($year, $month, 1, 0, 0, 0)->startOfMonth();
        $amountDaysInMonth = $date->format('t');

        foreach ($accommodations as $acom) {
            $availabilities[$acom->id] = $acom->available($date, (clone($date))->endOfMonth())->get()->keyBy('date');
        }

        return view('cabinet.partner.tours.calendar',
            compact(
                'tour',
                'accommodations',
                'date',
                'amountDaysInMonth',
                'availabilities'
            )
        );
    }

    public function mediaDelete($tourId, $mediaId)
    {
        $user = Auth::user();
        $tour = $user->tours()->findOrFail($tourId);
        $image = $tour->images()->find($mediaId);
        if (!$image) {
            $image = $tour->thumb()->find($mediaId);
        }
        if (!$image) {
            abort(500);
        }

        return response()->json(['success' => app(MediaRepository::class)->delete($image)]);
    }
}
