<?php
/**
 * Created by PhpStorm.

 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Place;
use App\PlacesGroup;
use Illuminate\Http\Request;

class PlacesController extends Controller
{

    public function index()
    {
        $places = Place::with('placesGroup')->get();
        $placesGroup = PlacesGroup::with('translations', 'places', 'places.translations')->get();
        return view('control.places.index', compact('placesGroup', 'places'));
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function view($id)
    {
        $placesGroup = PlacesGroup::with('translations')->get();
        $place = Place::findOrFail($id)->load('images');
        return view('control.places.view', compact('place', 'placesGroup'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'places_group_id' => 'required'
        ]);

        $place = Place::findOrFail($id);

        $place->fill($request->except(['name', 'page']));
        $result = $place->save();
        \Cache::forget('app:placeGroups:ru', 'app:placeGroups:en', 'app:placeGroups:ka');
        \Cache::forget('app:places:ru', 'app:places:en', 'app:places:ka');

        if ($request->ajax()) {
            return response()->json(['success' => $result, 'place' => $place, 'request' => $request->all()]);
        } else {
            return back()->with(['status' => 'success', 'msg' => 'Updated']);
        }
    }

}
