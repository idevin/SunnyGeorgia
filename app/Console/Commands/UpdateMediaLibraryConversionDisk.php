<?php

namespace App\Console\Commands;

use App\MediaLibrary;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class UpdateMediaLibraryConversionDisk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:conversionDisk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'media_library set conversion_disk field';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->update();
    }

    /**
     * Fetch rates from the API
     *
     * @return void
     */
    private function update(): void
    {
        $this->info('Updating ....');
        MediaLibrary::cursor()->each(
            fn (Media $media) => $media->update(['conversions_disk' => $media->disk])
        );
        $this->info('Updated!');
    }

    /**
     * Make the request to the sever.
     *
     * @return string
     */
}
