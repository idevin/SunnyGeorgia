<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TranslationsImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'i18n:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Translations to JSON file for frontend usage';

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
        $locales = config('translatable.locales');

        foreach ($locales as $locale) {
            foreach ($this->getAllLocaleFiles($locale) as $env => $files) {
                $this->storeFileData($this->getFilesData($files), $env, $locale);
            }
        }
    }

    /**
     * Get all locale files
     *
     * @return void
     */
    private function getAllLocaleFiles($locale)
    {
        return [
            'site' => glob(resource_path('lang/' . $locale . '/*.php')),
            'cabinet' => glob(resource_path('lang/' . $locale . '/cabinet/*.php'))
        ];
    }

    /**
     * Import data to file
     *
     * @return void
     */
    private function storeFileData($strings, $env, $locale)
    {
        $file_name = 'resources/assets/' . $env . '/js/locales/import/' . $locale . '.json';
        $file = fopen($file_name, 'w') or die('Error opening file: ' + $file_name);

        fwrite($file, json_encode($strings, JSON_PRETTY_PRINT));
        fclose($file);
    }

    /**
     * Get files data
     *
     * @return void
     */
    private function getFilesData($site_files)
    {
        $strings = [];

        foreach ($site_files as $file) {
            $name = basename($file, '.php');
            $string_unfiltered = require $file;
            $string_filtered = [];

            foreach ($string_unfiltered as $key => $value) {

                $sub_value_filtered = [];
                if (is_array($value)) {
                    foreach ($value as $sub_key => $sub_value) {
                        $sub_value_filtered[preg_replace('/\s+/', '_', $sub_key)] = $sub_value;
                    }
                } else {
                    $sub_value_filtered = $value;
                }

                $string_filtered[preg_replace('/\s+/', '_', $key)] = $sub_value_filtered;
            }

            $strings[$name] = $string_filtered;
        }

        return $strings;
    }
}
