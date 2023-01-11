<?php

namespace App\Console\Commands;

use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CopyImagesFromS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:images-from-s3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Копирует картинки с амазона в локальное хранилище';

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
        $folders = Storage::disk('excursions')->directories();

        foreach ($excursions as $excursion) {
            if (!in_array($excursion->id, $folders)) {
                dump('Excursion: ' . $excursion->id);
                if ($excursion->images) {
                    foreach ($excursion->images as $image) {
                        if ($stream = @fopen($image->url, 'r')) {
                            $excursion->addMediaFromUrl($image->url)
                                ->toMediaCollection('gallery');
                            echo '. ';
                        } else {
                            dump('url not reached:', $image->url);
                        }
                    }
                }
            }
        }

        $tours = Tour::query()->orderBy('updated_at', 'desc')->get();
        $folders = Storage::disk('tours')->directories();
        foreach ($tours as $excursion) {
            if (!in_array($excursion->id, $folders)) {
                dump('Tour: ' . $excursion->id);
                if ($excursion->images) {
                    foreach ($excursion->images as $image) {
                        if ($stream = @fopen($image->url, 'r')) {
                            $excursion->addMediaFromUrl($image->url)
                                ->toMediaCollection('gallery');
                            echo '. ';
                        } else {
                            dump('url not reached:', $image->url);
                        }
                    }
                }
            }
        }
    }
}
