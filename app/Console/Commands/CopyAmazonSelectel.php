<?php

namespace App\Console\Commands;

use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use ArgentCrusade\Selectel\CloudStorage\Api\ApiClient;
use ArgentCrusade\Selectel\CloudStorage\CloudStorage;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class CopyAmazonSelectel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:amazon-selectel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Amazon -> Selectel';

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
        $excursions = Excursion::query()->orderBy('updated_at', 'desc')->get();
        $tours = Tour::query()->orderBy('updated_at', 'desc')->get();

        $api = new ApiClient(env('SELECTEL_USER'), env('SELECTEL_PASSWORD'));
        $storage = new CloudStorage($api);
        $containers = $storage->containers();

        foreach (compact('tours', 'excursions') as $name => $objects) {
            if ($containers->has($name) === false) {
                dump('CREATE CONTAINER: ' . $name);
                $storage->createContainer($name);
            }
            $selectelDisk = Storage::disk('selectel_' . $name);
            self::syncS3($selectelDisk, $name);
        }

        if ($containers->has(env('AWS_BUCKET')) === false) {
            dump('CREATE CONTAINER: ' . env('AWS_BUCKET'));
            $storage->createContainer(env('AWS_BUCKET'));
        }

        $selectelDisk = Storage::disk('selectel_' . env('AWS_BUCKET'));
        self::syncS3($selectelDisk, env('AWS_BUCKET'));
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
