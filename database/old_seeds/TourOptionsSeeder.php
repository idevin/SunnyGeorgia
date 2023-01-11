<?php

use App\Option;
use App\OptionsGroup;
use Illuminate\Database\Seeder;

class TourOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
//            'Длительность тура' => [
//                '1-4 дня',
//                '5-9 дней',
//                '10+ дней',
//            ],
            'Питание' => [
                'Не включено',
                'BB - только завтрак',
                'HB - завтра и ужин',
                'FB - полный пансион',
                'AI - все включено',
                'UAI - ультра всё',
            ],
            'Типы туров' => [
                'Пляжный',
                'Горно-лыжные',
                'Лечебные',
                'Свадебные',
                'Экстремальные',
                'Гастрономические',
                'Экскурсионные',
                'Паломнические',
            ]
        ];

        foreach ($options as $title => $opts) {
            $this->addGroup($title, $opts);
        }

    }

    public function addGroup($title, $options)
    {
        $optGroup = new OptionsGroup();
        $optGroup->tours = true;
        $optGroup->fill([
            'ru' => [
                'title' => $title
            ],
        ]);
        $optGroup->save();

        foreach ($options as $optionTitle) {
            $this->addOption($optGroup, $optionTitle);
        }

    }

    public function addOption(OptionsGroup $group, $title)
    {
        $optionItem = new Option();
        $optionItem->fill([
                'ru' => [
                    'title' => $title
                ],
            ]
        );

        $group->options()->save($optionItem);
    }
}
