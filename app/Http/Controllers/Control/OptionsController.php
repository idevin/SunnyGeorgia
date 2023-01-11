<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\Option;
use App\OptionsGroup;
use Illuminate\Http\Request;

class OptionsController extends Controller
{

    public function index()
    {
        $options = OptionsGroup::orderBy('id')
            ->with('translations', 'options', 'options.translations')
            ->get();
        return view('control.options.index', compact('options'));
    }

    public function create()
    {
        return view('control.options.create');

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'main' => 'required',
//            'options' => 'required'
        ]);

        //UPDATE OPTION GROUP
        $optionGroup = new OptionsGroup();

        $optionGroup->fill($request->input('main'));

        $optionGroup->tours = $request->has('tours') ? true : false;
        $optionGroup->excursions = $request->has('excursions') ? true : false;
        $optionGroup->hotels = $request->has('hotels') ? true : false;
        $optionGroup->rooms = $request->has('rooms') ? true : false;
        $optionGroup->main_list = $request->has('main_list') ? true : false;

        $optionGroup->save();

        //SAVING NEW OPTIONS
        if ($request->has('newOption')) {
            foreach ($request->input('newOption') as $option) {
                $optionEntity = new Option();
                $optionEntity->fill($option);
//            $optionEntity->save();
                $optionGroup->options()->save($optionEntity);
            }
        }

        return redirect()
            ->route('control:options.edit', $optionGroup->id)
            ->with(['status' => 'success', 'msg' => 'Created']);


    }

    public function edit($id)
    {
        $optionGroup = OptionsGroup::findOrFail($id)->load('translations', 'options', 'options.translations');
        return view('control.options.edit', compact('optionGroup'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'main' => 'required',
            'options' => 'required'
        ]);

        //UPDATE OPTION GROUP
        $optionGroup = OptionsGroup::findOrFail($id);

        $optionGroup->fill($request->input('main'));

        $optionGroup->tours = $request->has('tours') ? true : false;
        $optionGroup->excursions = $request->has('excursions') ? true : false;
        $optionGroup->hotels = $request->has('hotels') ? true : false;
        $optionGroup->rooms = $request->has('rooms') ? true : false;
        $optionGroup->main_list = $request->has('main_list') ? true : false;
        $optionGroup->price = $request->has('price') ? true : false;

        $optionGroup->save();

        //UPDATE ISSET OPTIONS
        foreach ($request->input('options') as $optiondId => $option) {
            $optionEntity = Option::find($optiondId);
            $optionEntity->fill($option);
            $optionEntity->save();
        }

        //SAVING NEW OPTIONS
        if ($request->has('newOption')) {
            foreach ($request->input('newOption') as $option) {
                $optionEntity = new Option();
                $optionEntity->fill($option);
//            $optionEntity->save();
                $optionGroup->options()->save($optionEntity);
            }
        }

        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function optionDelete($id)
    {
        Option::findOrFail($id)->delete();
        return back()->with(['status' => 'success', 'msg' => 'Deleted']);
    }

    public function groupDelete($id)
    {
        OptionsGroup::findOrFail($id)->delete();
        return back()->with(['status' => 'success', 'msg' => 'Deleted']);
    }
}
