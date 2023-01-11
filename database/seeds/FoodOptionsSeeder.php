<?php

use Illuminate\Database\Seeder;

class FoodOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $foodOptions = [
            ['ru' => ['name' => 'BB - только завтрак'], 'en' => ['name' => 'BB - breakfast only'], 'ka' => ['name' => 'მხოლოდ საუზმე']],
            ['ru' => ['name' => 'HB - завтрак и ужин'], 'en' => ['name' => 'HB - breakfast & dinner'], 'ka' => ['name' => 'საუზმე და ვახშამი']],
            ['ru' => ['name' => 'FB - полный пансион'], 'en' => ['name' => 'FB - full board'], 'ka' => ['name' => 'სრული დაფა']]
        ];
        foreach($foodOptions as $optionData) {
            $this->findOrCreateByTranslation($optionData);
        }

    }

    protected function findOrCreateByTranslation($elem){
        try {
            return \App\Models\Tours\TourFoodOption::whereHas('translations', function($query) use ($elem) {
                $query->where('name', $elem['ru']['name'])->where('locale', 'ru');
            })->firstOrFail();
        } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return \App\Models\Tours\TourFoodOption::create($elem);
        }
    }
}
