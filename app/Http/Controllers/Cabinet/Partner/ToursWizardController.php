<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Cabinet\Partner;


use App\Http\Controllers\Controller;
use App\Language;
use App\Media;
use App\Models\Tours\Tour;
use App\OptionsGroup;
use Auth;
use Illuminate\Http\Request;
use Storage;

class ToursWizardController extends Controller
{


    public function store(Request $request)
    {
        $this->validate($request, [
//            'place_id' => 'required',
            'ru.title' => 'required',
        ]);

        $user = $request->user();


        $newTour = new Tour();
        $newTour->fill(
            $request->only(Language::all()->pluck('locale')->toArray())
        );

        $user->tours()->save($newTour);
        $newTour->slug = $newTour->id . '-' . str_slug($newTour->title);
        $newTour->save();

        return redirect()->route('cabinet:partner:tours.create.step2', $newTour->id)
            ->with(['status' => 'success', 'msg' => 'Tour created']);
    }

    public function create2($id, Request $request)
    {
        $tour = Auth::user()->tours()->findOrFail($id);
        return view('cabinet.partner.tours.create.step2', compact('tour'));

    }

    public function store2($id, Request $request)
    {
        $this->validate($request, [
            'start_place_id' => 'required',
        ]);
        $user = Auth::user();
        $tour = $user->tours()->findOrFail($id);

        $imagesUploadedAndSaved = [];
        if (!empty($request->files_uploader)) {
            foreach ($request->files_uploader as $image) {

                $imageName = md5(time()) . '.' . $image->getClientOriginalExtension();
                $t = Storage::cloud()->put('users/' . \Auth::user()->id . '/' . $imageName, file_get_contents($image), 'public');
                $imageNamePath = Storage::cloud()->url('users/' . \Auth::user()->id . '/' . $imageName);

                if ($t) {
                    $image = new Media();
                    $image->name = $imageName;
                    $image->url = $imageNamePath;

                    $user->images()->save($image);
                    $imagesUploadedAndSaved[] = $image->id;
                }
            }
        }
        if (!empty($request->thumb)) {

            $imageName = md5(time()) . '.' . $request->thumb->getClientOriginalExtension();
            $t = Storage::cloud()->put('users/' . \Auth::user()->id . '/' . $imageName, file_get_contents($request->thumb), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . \Auth::user()->id . '/' . $imageName);

            if ($t) {
                $image = new Media();
                $image->name = $imageName;
                $image->url = $imageNamePath;

                $user->images()->save($image);

                $tour->thumb_id = $image->id;
                $tour->save();
            }
        }
        $tour->images()->sync($imagesUploadedAndSaved);
        $tour->start_place_id = $request->input('start_place_id');
        $tour->save();

        return redirect()->route('cabinet:partner:tours.create.step3', $tour->id)
            ->with(['status' => 'success', 'msg' => 'Tour created']);
    }

    public function create3($id, Request $request)
    {
        $tour = Auth::user()->tours()->findOrFail($id);
        $optionGroups = OptionsGroup::where('tours', true)
            ->with('translations', 'options', 'options.translations')
            ->get();
        return view('cabinet.partner.tours.create.step3', compact('tour', 'optionGroups'));

    }

    public function store3($id, Request $request)
    {
        $tour = Auth::user()->tours()->findOrFail($id);

        if ($request->has('options')) {
            $optionsIds = array_keys($request->input('options'));
            $tour->options()->sync($optionsIds);
        }
        return redirect()->route('cabinet:partner:tours.edit', $tour->id)
            ->with(['status' => 'success', 'msg' => 'Saved!']);

    }

}