<?php

namespace App\Http\Controllers\Cabinet\Partner;

use App\Http\Controllers\Controller;
use App\Models\Excursions\Excursion;
use App\Models\Excursions\ExcursionAvailability;
use App\Models\Excursions\ExcursionType;
use App\OptionsGroup;
use App\Partner;
use App\PlacesGroup;
use App\Repositories\MediaRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ExcursionsController extends Controller
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
            $excursions = Excursion::query()->where('user_id', Auth::id())
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
                ->with('translations', 'place', 'place.translations', 'user', 'media')
                ->withTrashed($with_trashed)
                ->orderBy($order[0], $order[1])
                ->paginate(25);

            return response()->json($excursions);
        }
        $placesGroups = PlacesGroup::with('places')->get()->toJson();
        $fields = collect(['id', 'Дата', 'Картинка', 'Город', 'Вес', 'Заголовок'])->toJSON();

        return view('cabinet.partner.excursions.index', compact('user', 'placesGroups', 'fields'));
    }

    public function create()
    {
        $optionGroups = OptionsGroup::query()->where('excursions', true)
            ->with('translations', 'optionsCollection', 'optionsCollection.translations')
            ->get();
        return view('cabinet.partner.excursions.create', compact('optionGroups'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'place_id' => 'required'
        ]);

        $data = [];
        $user = Auth::user();

        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
            $translationsArray = $request->input($language, null);
            if ($translationsArray) {
                $title = $request->input($language . '.title', null);
                $translationsArray['slug'] = $title ? str_slug($title) : null;
                $request->merge([$language => $translationsArray]);
            }
        }

        $newExcursion = new Excursion;
        $newExcursion->fill($request->all());
        $user->excursions()->save($newExcursion);

        //create prices
        $prices = $request->input('prices');
        foreach ($prices as $price) {
            $newExcursion->prices()->create($price);
        }

        $newExcursion->slug = $newExcursion->id . '-' . str_slug($newExcursion->title);
        $newExcursion->save();

        //saving options
        if ($request->has('options')) {
            $optionsIds = $request->input('options');

            foreach ($optionsIds as $key => $value) {
                $optionsIds[$key] = is_array($value) ? $value : $key;
                unset($optionsIds[$key]['id']);
            }
            $newExcursion->options()->sync($optionsIds);
        }

        $data['excursion'] = $newExcursion;

        if ($request->ajax()) {
            $data['success'] = true;
            $data['msg'] = 'Excursion created';
            $data['redirect'] = route('cabinet:partner:excursions.edit', ['excursion' => $newExcursion->id]);
            return response()->json($data);
        } else {

            return redirect()->route('cabinet:partner:excursions.edit', ['excursion' => $newExcursion->id]);
        }
    }

    public function edit($excursionId)
    {
        $user = Auth::user();
        $excursion = $user->excursions()->findOrFail($excursionId)
            ->makeVisible(['commission', 'commission_proposal'])
            ->load(
                'translations',
                'options',
                'options.translations',
                'place',
                'types',
                'prices'
            );
        $optionGroups = OptionsGroup::where('excursions', true)
            ->with('translations', 'optionsCollection', 'optionsCollection.translations')
            ->get();
        $excursionTypes = ExcursionType::withTranslation()->get();
        $currentExcursionTypesIds = $excursion->types->pluck('id');
        $excursion->load('user', 'ribbon');
        $permissions = Auth::user()->allPermissions();
        $gallery = [];
        foreach ($excursion->getMedia('excursions') as $index => $item) {
            $gallery[] = ['url' => $item->getUrl(), 'id' => $item->id];
        }

        return view(
            'cabinet.partner.excursions.edit',
            compact(
                'excursion',
                'optionGroups',
                'gallery',
                'excursionTypes',
                'currentExcursionTypesIds',
                'permissions'
            )
        );
    }

    public function update($excursionId, Request $request)
    {
        $this->validate($request, [
            'ru.title' => 'required',
            'options' => 'array',
        ]);
        $excursion = Excursion::findOrFail($excursionId);
        $excursion->fill($request->all());
        if ($request->has('prices')) {
            $excursion->prices()->delete();
            $prices = $request->input('prices');
            foreach ($prices as $price) {
                $excursion->prices()->create($price);
            }
        }
        $excursion->save();
        //saving options
        if ($request->has('options')) {
            $optionsIds = $request->input('options');
            foreach ($optionsIds as $key => $value) {
                $optionsIds[$key] = is_array($value) ? $value : $key;
                unset($optionsIds[$key]['id']);
            }
            $excursion->options()->sync($optionsIds);
        } else {
            $excursion->options()->detach();
        }
        $excursion->types()->sync($request->input('types', []));
        return response()->json([
            'excursion' => $excursion->fresh(['translations', 'options', 'place', 'types']),
            'success' => true,
            'msg' => 'Excursion updated'
        ]);
    }

    public function delete($excursionId)
    {
        $user = Auth::user();
        //$result = $user->excursions()->find($excursionId)->delete();
        $excursion = $user->excursions()->find($excursionId);
        $excursion->prices()->delete();
        $result = $excursion->delete();

        return redirect()->route('cabinet:partner:excursions.index', ['success' => $result]);
    }

    public function mediaDelete($excursionId, $mediaId)
    {
        $user = Auth::user();
        $excursion = $user->excursions()->findOrFail($excursionId);
        $image = $excursion->images()->findOrFail($mediaId);

        return response()->json(['success' => app(MediaRepository::class)->delete($image)]);
    }

    public function calendar($excursionId, Request $request)
    {
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));
        $excursion = Auth::user()->excursions()->findOrFail($excursionId);
        $date = Carbon::create($year, $month, 1, 0, 0, 0)->startOfMonth();
        $amountDaysInMonth = $date->format('t');

        $times = $excursion->availableTimes();
        $availabilities = [];
        foreach ($times as $time) {
            $availabilities[$time] = $excursion->available($time, $date, (clone($date))->endOfMonth())->orderBy('date')->get()->keyBy('date');
        }
        return view('cabinet.partner.excursions.calendar', compact(
            'times',
            'excursion',
            'date',
            'amountDaysInMonth',
            'availabilities'));
    }

    /**
     * @param $excursionId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postAvailability($excursionId, Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'amount' => 'required|integer|min:0|max:99999',
            'times' => 'required|array',
            'times.*' => 'required|date_format:H:i:s',
            'clean' => 'bool'

        ]);
        $excursion = Auth::user()->excursions()->findOrFail($excursionId);

        $weekDays = array_keys($request->input('day_of_week', []));
        $dateTo = Carbon::parse($request->input('date_to'))->startOfDay();
        $timeArray = $request->input('times');

        for ($dateFrom = Carbon::parse($request->input('date_from'))->startOfDay(); $dateTo->diffInDays($dateFrom, false) <= 0; $dateFrom->addDay()) {
            foreach ($timeArray as $time) {
                if (!in_array($dateFrom->dayOfWeek, $weekDays)) {
                    continue;
                }
                $data = [
                    'excursion_id' => $excursion->id,
                    'date' => $dateFrom->toDateString(),
                    'time' => $time,
                    'amount' => (int)$request->input('amount'),
                ];
                ExcursionAvailability::updateOrCreate([
                    'date' => $dateFrom->toDateString(),
                    'time' => $time,
                    'excursion_id' => $excursion->id
                ],
                    $data);

            }

            if ($request->input() == 'true') {
                ExcursionAvailability::whereNotIn('time', $timeArray)
                    ->where('excursion_id', $excursion->id)
                    ->whereDate($dateFrom)
                    ->delete();
            }


        }
        return back();

    }

    public function deleteAvailabilities($excursionId, Request $request)
    {
        $this->validate($request, [
            'time' => 'required'
        ]);
        $excursion = Auth::user()->excursions()->findOrFail($excursionId);

        $excursion->availabilities()->where('time', $request->input('time'))->delete();
        return back();
    }

    public function postAvailabilityForm($excursionId, Request $request)
    {
        $this->validate($request, [
//            'accommodation_id' => 'required|exists:accommodations,id',
            'availability.*' => 'required'
        ]);

        $excursion = Auth::user()->excursions()->findOrFail($excursionId);

        $availability = collect($request->input('availability', []));

        foreach ($availability as $time => $dates) {
            foreach ($dates as $date => $amount) {
                $amount = (int)$amount;

                $dateFrom = Carbon::parse($date)->startOfDay();
                ExcursionAvailability::updateOrCreate([
                    'date' => $dateFrom->toDateString(),
                    'time' => $time,
                    'excursion_id' => $excursion->id
                ],
                    [
                        'excursion_id' => $excursion->id,
                        'date' => $dateFrom->toDateString(),
                        'time' => $time,
                        'amount' => 0 <= $amount && $amount <= 99999 ? $amount : null,
//                        'discount_percent' => (float)$request->input('discount'),
//                        'price_special_gel' => (float)$request->input('price'),
                    ]);
            }
        }
        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function deleteAvailability($availabilityId)
    {
        //todo add security!!!
        ExcursionAvailability::find($availabilityId)->delete();
        return back();
    }
}
