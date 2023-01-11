<?php

use Illuminate\Database\Seeder;

class ExcursionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elems = [
            ['ru' => ['name' => 'Обзорная'], 'en' => ['name' => 'Sightseeing'], 'ka' => ['name' => 'მიმოხილვა']],
            ['ru' => ['name' => 'Горы и каньоны'], 'en' => ['name' => 'Mountains & canyons'], 'ka' => ['name' => 'მთები, კანიონები']],
            ['ru' => ['name' => 'Винно-гастрономическая'], 'en' => ['name' => 'Wine, gastronomy'], 'ka' => ['name' => 'გასტრონომიური']],
            ['ru' => ['name' => 'Пешие и вело'], 'en' => ['name' => 'Walking & Biking'], 'ka' => ['name' => 'სასიარულო და ველო']],
            ['ru' => ['name' => 'История, архитектура'], 'en' => ['name' => 'History, architecture'], 'ka' => ['name' => 'ისტორია, არქიტექტურა']],
            ['ru' => ['name' => 'Мастер-классы'], 'en' => ['name' => 'Classes & Workshops'], 'ka' => ['name' => 'მასტერკლასები']],
            ['ru' => ['name' => 'Морские и водные'], 'en' => ['name' => 'Sea and water'], 'ka' => ['name' => 'ზღვა და წყალი']],
            ['ru' => ['name' => 'Археология и этнография'], 'en' => ['name' => 'Archeology & ethnography'], 'ka' => ['name' => 'არქეოლოგია და ეთნოგრაფია']],
            ['ru' => ['name' => 'Шопинг и мода'], 'en' => ['name' => 'Shopping & Fashion'], 'ka' => ['name' => 'შოპინგი']],
            ['ru' => ['name' => 'Гарантированная'], 'en' => ['name' => 'Guarantied'], 'ka' => ['name' => 'გარანტირებული']],
            ['ru' => ['name' => 'Спорт, экстрим'], 'en' => ['name' => 'Sport, Extreme'], 'ka' => ['name' => 'სპორტი']],
            ['ru' => ['name' => 'Другие'], 'en' => ['name' => 'Other'], 'ka' => ['name' => 'სხვა']],
            ['ru' => ['name' => 'Мцхета'], 'en' => ['name' => 'Mtskheta'], 'ka' => ['name' => 'მცხეთა']],
            ['ru' => ['name' => 'Казбеги'], 'en' => ['name' => 'Kazbegi'], 'ka' => ['name' => 'ყაზბეგი']],
            ['ru' => ['name' => 'Кахети'], 'en' => ['name' => 'Kakheti'], 'ka' => ['name' => 'კახეთი']],
        ];
        foreach($elems as $elem) {
            $this->findOrCreateByTranslation($elem);
        }

    }

    protected function findOrCreateByTranslation($elem){
        try {
            return \App\Models\Excursions\ExcursionType::whereHas('translations', function($query) use ($elem) {
                $query->where('name', $elem['ru']['name'])->where('locale', 'ru');
            })->firstOrFail();
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return \App\Models\Excursions\ExcursionType::create($elem);
        }
    }
}
