<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $langs = [
            'en' => 'English',
            'ru' => 'Русский',
            'ge' => 'ქართული ენა'
        ];

        foreach ($langs as $locale => $name) {
            $langModel = new \App\Language();
            $langModel->locale = $locale;
            $langModel->name = $name;
            $langModel->save();
        }
    }
}
