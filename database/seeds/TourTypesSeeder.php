<?php

use Illuminate\Database\Seeder;

class TourTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elems = [
            ['ru' => ['name' => 'Экскурсионный'], 'en' => ['name' => 'Sightseeing'], 'ka' => ['name' => 'საექსკურსიო']],
            ['ru' => ['name' => 'Море, пляж'], 'en' => ['name' => 'Sea, beach'], 'ka' => ['name' => 'ზღვა, სანაპირო']],
            ['ru' => ['name' => 'Винно-гастрономический'], 'en' => ['name' => 'Wine gastronomy'], 'ka' => ['name' => 'ღვინო და გასტრონომია']],
            ['ru' => ['name' => 'Комбинированный'], 'en' => ['name' => 'Combined'], 'ka' => ['name' => 'კომბინირებული']],
            ['ru' => ['name' => 'Горнолыжный'], 'en' => ['name' => 'Alpine skiing'], 'ka' => ['name' => 'სათხილამურო']],
            ['ru' => ['name' => 'Праздники'], 'en' => ['name' => 'Holidays'], 'ka' => ['name' => 'არდადეგები']],
            ['ru' => ['name' => 'Активные туры'], 'en' => ['name' => 'Active tours'], 'ka' => ['name' => 'აქტიური ტურები']],
            ['ru' => ['name' => 'Спорт, экстрим'], 'en' => ['name' => 'Sport, Extreme'], 'ka' => ['name' => 'სპორტი და ექსტრიმი']],
            ['ru' => ['name' => 'Лечение, терапия'], 'en' => ['name' => 'Treatment, therapy'], 'ka' => ['name' => 'მკურნალობა, თერაპია']],
            ['ru' => ['name' => 'История, архитектура'], 'en' => ['name' => 'History, architecture'], 'ka' => ['name' => 'ისტორია, არქიტექტურა']],
            ['ru' => ['name' => 'Свадебный'], 'en' => ['name' => 'Wedding'], 'ka' => ['name' => 'ქორწილი']],
            ['ru' => ['name' => 'Паломнический'], 'en' => ['name' => 'Pilgrim'], 'ka' => ['name' => 'მომლოცველები']],
            ['ru' => ['name' => 'Гарантированные даты'], 'en' => ['name' => 'Guaranteed Dates'], 'ka' => ['name' => 'გარანტირებული']],
            ['ru' => ['name' => 'По запросу'], 'en' => ['name' => 'Upon request'], 'ka' => ['name' => 'მოთხოვნისთანავე']],
            ['ru' => ['name' => 'Другие'], 'en' => ['name' => 'Other'], 'ka' => ['name' => 'სხვა']],
        ];
        foreach($elems as $elem) {
            $this->findOrCreateByTranslation($elem);
        }

    }

    protected function findOrCreateByTranslation($elem){
        try {
            return \App\Models\Tours\TourType::whereHas('translations', function($query) use ($elem) {
                $query->where('name', $elem['ru']['name'])->where('locale', 'ru');
            })->firstOrFail();
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return \App\Models\Tours\TourType::create($elem);
        }
    }
}
