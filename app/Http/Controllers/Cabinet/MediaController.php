<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Controller;
use App\Media;
use App\MediaLibrary;
use App\Models\Tours\Tour;
use App\Partner;
use App\Repositories\MediaRepository;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use ImageLib;
use Log;
use Response;
use Storage;

class MediaController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function uploadFile(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image',
            'tour_id' => 'integer|exists:tours,id'
        ]);
        if ($request->hasFile('image')) {
            $imageName = str_random(32) . '.' . $request->file('image')->getClientOriginalExtension();

            //compressing image
            $contents = file_get_contents($request->file('image'));
            $image = ImageLib::make($contents);
            //840 width for slider * 2 = 1680 for highdensity images
            $imageNormal = $image->resize(840, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75);
            $imageNormal = $imageNormal->stream();

            $t = Storage::cloud()->put('users/' . Auth::user()->id . '/' . $imageName, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . Auth::user()->id . '/' . $imageName);

            if ($t) {
                $image = new Media();
                $image->name = $imageName;
                $image->url = $imageNamePath;

                $user = Auth::user();

                $user->images()->save($image);
                if ($user->hasRole('admin')) {
                    $tour = Tour::find((int)$request->input('tour_id'));
                } else {
                    $tour = $user->tours()->find((int)$request->input('tour_id'));
                }
                if ($request->has('tour_id')) {
                    if ($request->has('gallery') && $request->input('gallery')) {
                        $tour->images()->attach($image->id);
                    } elseif ($request->has('thmb') && $request->input('thmb')) {
                        $tour->thumb_id = $image->id;
                        $tour->save();

                    }
                }
                return Response::json(['success' => true, 'file' => $image], 200);
            }
        }
        return Response::json(['success' => false], 400);

    }

    public function uploadAvatar(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image',
            'user_id' => 'required|integer|exists:users,id'
        ]);
        if ($request->hasFile('avatar')) {
            $imageName = str_random(32) . '.' . $request->file('avatar')->getClientOriginalExtension();

            $image = ImageLib::make($request->file('avatar'));
            $imageNormal = $image->resize(600, 600, function ($constraint) {
                $constraint->upsize();
            });

            $imageNormal = $imageNormal->stream();

            $t = Storage::cloud()->put('users/' . Auth::user()->id . '/' . $imageName, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . Auth::user()->id . '/' . $imageName);

            if ($t) {
                $user = $request->user();
                $image = new Media();
                $image->name = $imageName;
                $image->url = $imageNamePath;
                $image->user_id = $user->id;
                $image->save();

                $user->avatar_id = $image->id;
                $user->save();


                return Response::json(['success' => true, 'file' => $image], 200);
            }
        }
        return Response::json(['success' => false], 400);
    }

    public function uploadCompanyLogo(Request $request)
    {
        $this->validate($request, [
            'avatar' => 'required|image',
            'partner_id' => 'integer|exists:partners,id'
        ]);
        if ($request->hasFile('avatar')) {
            $imageName = str_random(32) . '.' . $request->file('avatar')->getClientOriginalExtension();

            $image = ImageLib::make($request->file('avatar'));
            $imageNormal = $image->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageNormal = $imageNormal->stream();

            $t = Storage::cloud()->put('users/' . Auth::user()->id . '/' . $imageName, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . Auth::user()->id . '/' . $imageName);

            if ($t) {
                $user = $request->user();
                $image = new Media();
                $image->name = $imageName;
                $image->url = $imageNamePath;
                $image->user_id = $user->id;
                $image->save();

                /**
                 * @review небезопасное использование метода findOrFail, так как он при ошибке отдает ModelNotFoundException.
                 * Я б использовал метод find и проверял на наличие записи в базе или try catch обработку исключения. По коду проекта много использований этого метода.
                 **/
                $partner = Partner::findOrFail($request->input('partner_id'));
                $partner->logo_image_id = $image->id;
                $partner->save();


                return Response::json(['success' => true, 'file' => $image], 200);
            }
        }
        return Response::json(['success' => false], 400);
    }

    public function uploadMany(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|array',
            'image.*' => 'required|image',
            'tour_id' => 'integer|exists:tours,id'
        ]);

        $user = Auth::user();
        foreach ($request->file('image') as $file) {

            $imageName = str_random(32) . '.' . $file->getClientOriginalExtension();

            //compressing image
            $contents = file_get_contents($file);
            $image = ImageLib::make($contents);
            //840 width for slider * 2 = 1680 for highdensity images
            $imageNormal = $image->resize(840, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->encode('jpg', 75);
            $imageNormal = $imageNormal->stream();


            $t = Storage::cloud()->put('users/' . Auth::user()->id . '/' . $imageName, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url('users/' . Auth::user()->id . '/' . $imageName);

            if ($t) {
                $image = new Media();
                $image->name = $imageName;
                $image->url = $imageNamePath;

                $user->images()->save($image);
                if ($request->has('tour_id')) {
                    if ($user->hasRole('admin')) {
                        $tour = Tour::find((int)$request->input('tour_id'));
                    } else {
                        $tour = $user->tours()->find((int)$request->input('tour_id'));
                    }

                    if ($request->has('gallery') && $request->input('gallery')) {
                        $tour->images()->attach($image->id);
                    } elseif ($request->has('thmb') && $request->input('thmb')) {
                        $tour->thumb_id = $image->id;
                        $tour->save();
                    }
                }
            }
        }

        return Response::json(['success' => true, 'file' => $image], 200);
    }

    public function uploader(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|array',
            'image.*' => 'required',
            'model' => 'required',
            'model_id' => 'required'
        ]);
        $modelName = $request->input('model');
        $user = Auth::user();
        try {
            if ($user->hasRole('admin')) {
                switch ($modelName) {
                    case 'Excursions':
                        $modelClassName = '\App\\Models\\Excursions\\Excursion';
                        break;
                    case 'Tours':
                        $modelClassName = '\App\\Models\\Tours\\Tour';
                        break;
                }
                $model = $modelClassName::findOrFail($request->input('model_id'));
            } else {
                $model = $user->$modelName()->findOrFail($request->input('model_id'));
            }
            $model->addAllMediaFromRequest()->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('gallery');
            });
            return response()->json('success');
        } catch (\Throwable $e) {
            Log::error($e->getMessage(), ['uploader', \Illuminate\Support\Facades\Auth::user(), $request->all()]);
            return response()->json(['success' => false], 500);
        }
    }

    public function delete($id)
    {
        $image = MediaLibrary::destroy($id);
        return response()->json(['success' => $image]);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function uploaderTiny(Request $request)
    {
        /** @var TYPE_NAME $request */
        $this->validate($request, [
            'file' => 'required|image',
        ]);
        try {
            $file = $request->file('file');
            $result = app(MediaRepository::class)->save_tiny(Auth::user(), $file);
            return Response::json($result, 200);
        } catch (\Throwable $e) {
            Log::error($e->getMessage(), ['uploader', Auth::user(), $request->all()]);
            return Response::json(['success' => false], 500);
        }
    }
}
