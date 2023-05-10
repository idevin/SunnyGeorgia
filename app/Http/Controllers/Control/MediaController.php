<?php
/**
 * Created by PhpStorm.

 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Control;


use App\Http\Controllers\Controller;
use App\MediaLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function uploader(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|array',
            'image.*' => 'required',
            'model' => 'required',
            'model_id' => 'required'
        ]);

        $modelName = $request->input('model');
        if ($modelName === 'Excursions') {
            $model = '\App\\Models\\Excursions\\Excursion';
        } elseif ($modelName === 'Tours') {
            $model = '\App\\Models\\Tours\\Tour';
        } else {
            $model = '';
        }
        $model = $model::findOrFail($request->input('model_id'));

        try {
            $model->addAllMediaFromRequest()
                ->each(function ($fileAdder) use ($modelName) {
                    $fileAdder->toMediaCollection(lcfirst($modelName));
                });
            return response()->json('success');
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        $image = MediaLibrary::destroy($id);
        return response()->json(['success' => $image]);
    }
}
