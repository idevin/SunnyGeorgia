<?php

namespace App\Console\Commands;

use App\MediaLibrary;
use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use ArgentCrusade\Selectel\CloudStorage\Api\ApiClient;
use ArgentCrusade\Selectel\CloudStorage\CloudStorage;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\ConsoleMakeCommand;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Psy\Readline\Hoa\Console;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CopySelectelLocal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:selectel-local';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Selectel -> Local disk';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $fs = new Filesystem();
        $media = MediaLibrary::query()->get();

        foreach ($media as $mediaObject) {

            $type = config('media-library.' . $mediaObject->disk);

            $relativeUrl = '/' . $mediaObject->model_id . '/' . $mediaObject->collection_name
                . '/' . $mediaObject->id . '/';

            $fullUrl = $type['domain'] . $relativeUrl . urlencode($mediaObject->file_name);

            $bin = file_get_contents($fullUrl);
            $fullPath = public_path('storage/media') . '/' . $mediaObject->disk . $relativeUrl;

            if (!$fs->exists($fullPath)) {
                $fs->makeDirectory($fullPath, 0777, true);
            }

            $file = $fullPath . $mediaObject->file_name;

            if (!$fs->exists($file)) {
                $this->info("PUTTING FILE: " . $file);
                file_put_contents($file, $bin);
            } else {
                $this->info("FILE EXISTS: " . $file);
            }
        }
    }

    /**
     * @param \Illuminate\Contracts\Filesystem\Filesystem $bucket
     * @param string $awsBucketName
     */
    public static function syncS3($bucket, $awsBucketName)
    {
        $awsDisk = Storage::disk($awsBucketName);
        $aws = $awsDisk->allDirectories();

        foreach ($aws as $dir) {
            if ($bucket->exists($dir) == false) {
                dump('DIR: ' . $dir);
                $bucket->makeDirectory($dir);
            } else {
                dump('DIR EXISTS: ' . $dir);
            }

            $files = $awsDisk->files($dir);

            if (!empty($files)) {
                foreach ($files as $file) {
                    try {
                        if ($bucket->exists($file) == false) {
                            dump('PUT FILE: -> ' . $file);
                            $resourceFile = $awsDisk->get($file);
                            $bucket->put($file, $resourceFile);
                        } else {
                            dump('FILE EXISTS: -> ' . $file);
                        }
                    } catch (FileNotFoundException $e) {
                        dump($e->getMessage());
                    }
                }
            }
        }
    }
}
