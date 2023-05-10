<?php
/**
 * Created by PhpStorm.

 * Date: 03.05.2018
 * Time: 17:25
 */

namespace App\Repositories;


use App\Media;
use App\User;
use ImageLib;
use Storage;

class MediaRepository
{

    public $width = 840;

    public function save(User $user, $model, $file)
    {

        $imageName = str_random(32) . '.' . $file->getClientOriginalExtension();
        //compressing image
        $contents = file_get_contents($file);
        $imageSrc = ImageLib::make($contents);


        $image = new Media();
        $image->name = $imageName;


        if ($imageSrc->width() > 840) {
            $imageResized = $this->resize($imageSrc, 1680);
            $imagePathHigh = $this->upload($imageResized, $imageName, $model, 'high');

            $image->path_high = $imagePathHigh['path'];
            $image->url_high = $imagePathHigh['url'];
        }

        $imageResized = $this->resize($imageSrc, 840);
        $imagePathesNormal = $this->upload($imageResized, $imageName, $model, 'normal');

        $image->path = $imagePathesNormal['path'];
        $image->url = $imagePathesNormal['url'];
        $image->model_type = get_class($model);
        $image->model_id = $model->id;

        $user->images()->save($image);
        $model->images()->attach($image->id);


        return true;
    }

    public function resize($image, $width)
    {
        //840 width for slider * 2 = 1680 for highdensity images
        $imageNormal = $image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->encode('jpg', 75);
        return $imageNormal->stream();
    }

    public function upload($file, $imageName, $model, $type)
    {
        $modelId = $model->id;

        $path = strtolower(class_basename($model)) . '/' . $modelId . '/' . $type . '/' . $imageName;
        $uploadResult = Storage::cloud()->put($path, $file->__toString(), 'public');
        if ($uploadResult) {
            return ['url' => Storage::cloud()->url($path), 'path' => $path];
        } else {
            return false;
        }
    }

    public function delete(Media $media)
    {
        if ($media->path) {
            Storage::cloud()->delete($media->path);
            if ($media->path_high) {
                Storage::cloud()->delete($media->path_high);
            }
        } else {
            Storage::cloud()->delete('users/' . $media->user_id . '/' . $media->name);
        }

        return $media->delete();
    }

    public function save_tiny(User $user, $file)
    {

        $imageName = str_random(32) . '.' . $file->getClientOriginalExtension();
        //compressing image
        $contents = file_get_contents($file);
        $imageSrc = ImageLib::make($contents);


        $image = new Media();
        $image->name = $imageName;


        if ($imageSrc->width() > 840) {
            $imageResized = $this->resize($imageSrc, 1680);
            $imagePathHigh = $this->upload_tiny($imageResized, $imageName, $user->id, 'high');

            $image->path_high = $imagePathHigh['path'];
            $image->url_high = $imagePathHigh['url'];
        }

        $imageResized = $this->resize($imageSrc, 840);
        $imagePathesNormal = $this->upload_tiny($imageResized, $imageName, $user->id, 'normal');

        $image->path = $imagePathesNormal['path'];
        $image->url = $imagePathesNormal['url'];

        $user->images()->save($image);

        return ['location' => Storage::cloud()->url($image->path), 'path' => $image->path];
    }

    public function upload_tiny($file, $imageName, $uid, $type)
    {

        $path = 'tinymce/' . $uid . '/' . $type . '/' . $imageName;
        $uploadResult = Storage::cloud()->put($path, $file->__toString(), 'public');
        if ($uploadResult) {
            return ['url' => Storage::cloud()->url($path), 'path' => $path];
        } else {
            return false;
        }
    }
}