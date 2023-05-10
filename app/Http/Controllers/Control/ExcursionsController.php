<?php
/**
 * Created by PhpStorm.

 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use App\MediaLibrary;
use App\Models\Excursions\Excursion;
use App\Models\Excursions\ExcursionAvailability;
use App\Models\Excursions\ExcursionType;
use App\OptionsGroup;
use App\PlacesGroup;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ExcursionsController extends Controller
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
            $excursions = Excursion::whereHas('translations', function ($query) use ($search_title) {
                $query->where("title", "LIKE", "%$search_title%");
            })
                ->whereHas('place', function ($query) use ($search_place_id) {
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
                ->with('translations', 'place', 'place.translations', 'user', 'media')
                ->orderBy($order[0], $order[1])
                ->withTrashed($with_trashed)
                ->paginate(25);

            return response()->json($excursions);
        }

        $excursions = [];
        //$excursions = Excursion::orderBy('id')->with('translations', 'user', 'place', 'place.translations')->paginate(25);
        $placesGroups = PlacesGroup::with('places')->get()->toJson();
        $users = User::has('excursions')->get()->toJson();
        $fields = collect(['id', 'Дата', 'Владелец', 'Картинка', 'Вес', 'Заголовок'])->toJSON();
        return view('control.excursions.index', compact('excursions', 'placesGroups', 'users', 'fields'));

    }

    public function edit($excursionId)
    {
        $users = User::all();
        $excursion = Excursion::findOrFail($excursionId)
            ->makeVisible(['commission', 'commission_proposal'])
            ->load(
                'translations',
                'options',
                'options.translations',
                'types',
                'prices',
                'places',
                'places.translations'
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
            $gallery[] = [
                'url' => $item->getUrl(),
                'id' => $item->id,
                'alt' => $item->getCustomProperty('alt', ''),
                'mainImage' => $item->hasCustomProperty('main'),
            ];
        }
        return view(
            'control.excursions.edit',
            compact(
                'excursion',
                'optionGroups',
                'gallery',
                'excursionTypes',
                'currentExcursionTypesIds',
                'permissions',
                'users'
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

        $excursion->places()->sync($request->input('places', []));

        $this->setMedia($request->input('images', []), $request->input('main_image', null));

        return response()->json([
            'excursion' => $excursion->fresh(['translations', 'options', 'place', 'types']),
            'success' => true,
            'msg' => 'Excursion updated'
        ]);
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

    /**
     * @param $excursionId
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateModeratorData($excursionId, Request $request)
    {
        $this->validate($request, [
            'slug:ru' => 'required',
        ]);
        foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
            $request['slug:' . $language] = $request->input('slug:' . $language) ?
                str_slug($request['slug:' . $language]) : null;
            $request['noindex_' . $language] = $request->has('noindex_' . $language);
        }
        $excursion = Excursion::query()->findOrFail($excursionId);

        $excursion->fill(
            $request->all()
        );
        if ($request->has('ribbon_id')) {
            if ($request->filled('ribbon_id')) {
                $excursion->ribbon()->associate($request->input('ribbon_id'));
            } else {
                $excursion->ribbon()->dissociate();;
            }
        }
        if ($request->has('reviewed')) {
            $excursion->reviewed = $request->input('reviewed');
        }
        if ($request->has('user_id')) {
            $excursion->user_id = $request->input('user_id');
        }
        $excursion->save();
        return back()->with(['status' => 'success', 'msg' => 'Настройки тура сохранены']);
    }

    public function calendar($excursionId, Request $request)
    {
        $yearMin = date('Y') - 1;
        $yearMax = $yearMin + 20;
//        $this->validate($request, [
//            'month' => 'digits_between:1,12|integer',
//            'year' => 'digits_between:' . $yearMin . ',' . $yearMax . '|integer',
//        ]);

        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $excursion = Excursion::findOrFail($excursionId);
        $date = Carbon::create($year, $month, 1, 0, 0, 0)->startOfMonth();
        $amountDaysInMonth = $date->format('t');

        $times = $excursion->availableTimes();
        $availabilities = [];
        foreach ($times as $time) {
            $availabilities[$time] = $excursion->available($time, $date, (clone($date))->endOfMonth())->orderBy('date')->get()->keyBy('date');
        }
        return view('control.excursions.calendar', compact(
            'times',
            'excursion',
            'date',
            'amountDaysInMonth',
            'availabilities'));
    }

    public function postAvailability($excursionId, Request $request)
    {
        $this->validate($request, [
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'amount' => 'required|integer',
            'times' => 'required|array',
            'times.*' => 'required|date_format:H:i',
            'clean' => 'bool'

        ]);
        $excursion = Excursion::findOrFail($excursionId);

        $weekDays = array_keys($request->input('day_of_week', []));
        $dateTo = Carbon::parse($request->input('date_to'))->startOfDay();
        $dateFrom = Carbon::parse($request->input('date_from'))->startOfDay();
        $timeArray = $request->input('times');

        for ($dateFrom; $dateTo->diffInDays($dateFrom, false) <= 0; $dateFrom->addDay()) {
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
                ], $data);
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

        $excursion = Excursion::findOrFail($excursionId);
        $excursion->availabilities()->where('time', $request->input('time'))->delete();
        return back();
    }

    public function postAvailabilityForm($excursionId, Request $request)
    {
        $this->validate($request, [
//            'accommodation_id' => 'required|exists:accommodations,id',
            'availability.*' => 'required'
        ]);

        $excursion = Excursion::findOrFail($excursionId);

        $availability = collect($request->input('availability', []));

        foreach ($availability as $time => $dates) {
            foreach ($dates as $date => $amount) {
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
                        'amount' => (int)$amount,
//                        'discount_percent' => (float)$request->input('discount'),
//                        'price_special_gel' => (float)$request->input('price'),
                    ]);
            }
        }
        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function delete($id)
    {
        Excursion::find($id)->prices()->delete();
        $result = Excursion::destroy($id);
        return redirect()->route('control:excursions.index', ['success' => $result]);
    }
}
