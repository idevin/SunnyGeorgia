<?php

use App\Media;
use Illuminate\Database\Migrations\Migration;

class UpdateMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $media = Media::query()->get();
        $cdnUrl = 'https://352207.selcdn.ru/';
        foreach ($media as $object) {
            $url = parse_url($object->url);
            if (isset($url['host']) && isset($url['path'])) {
                $matched = preg_match('/amazon/', $url['host']);
                if (!empty($matched)) {
                    $bucket = preg_split('/\./', $url['host'])[0];
                    $path = preg_split('/\//', $url['path']);
                    array_pop($path);
                    $path = implode('/', $path);
                    $fullUrl = $cdnUrl . $bucket . $path . DIRECTORY_SEPARATOR . $object->name;
                    $object->update(['url' => $fullUrl]);
                    dump('NEW URL: ' . $object->id . ' -> ' . $fullUrl);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
