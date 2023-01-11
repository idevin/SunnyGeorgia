<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Http\Request;
use Storage;

class S3ImageController extends Controller
{

    /**
     * Create view file
     *
     */
    public function imageUpload()
    {
        $files = Storage::cloud()->files('users/' . \Auth::user()->id);
        foreach ($files as $key => $file) {
            $files[$key] = Storage::cloud()->url($file);
        }
        return view('image-upload', compact('files'));
    }

    /**
     * Manage Post Request
     *
     */
    public function imageUploadPost(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = md5(time()) . '.' . $request->image->getClientOriginalExtension();
        $image = $request->file('image');
        $t = Storage::cloud()->put('users/' . \Auth::user()->id . '/' . $imageName, file_get_contents($image), 'public');
        $imageNamePath = Storage::cloud()->url('users/' . \Auth::user()->id . '/' . $imageName);

        if ($t) {
            $image = new Media();
            $image->name = $imageName;
            $image->url = $imageNamePath;

            $request->user()->images()->save($image);
        }

        return back()
            ->with(['status' => 'success', 'msg' => 'Image Uploaded successfully.'])
            ->with('path', $imageNamePath)
            ->with('imageName', $imageName);
    }

    public function getImage($id)
    {
        $image = Media::find($id);
        return '<img src="' . $image->url . '">';
    }
}