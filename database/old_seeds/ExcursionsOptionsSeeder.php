<?php

use App\Option;
use App\OptionsGroup;
use AppOld\OldOption;
use Illuminate\Database\Seeder;

class ExcursionsOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $optionObject = OldOption::where('category', 5)->get();

        foreach ($optionObject as $obj) {
//            dump($obj->unser('ml_title'));
//            dump($obj->category);
            $var['ml_title'] = $obj->unser('ml_title');

            $newExcursionOptGroup = new OptionsGroup();
            $newExcursionOptGroup->excursions = true;
            $newExcursionOptGroup->fill([
                'ru' => [
                    'title' => trim($var['ml_title']['ru'])
                ],
                'ge' => [
                    'title' => !empty($var['ml_title']['ka']) ? trim($var['ml_title']['ka']) : '',
                ]
            ]);
            $newExcursionOptGroup->save();

            $subList = $obj->subList()->get();
            foreach ($subList as $opt) {
                $sVar = [];
                $sVar['ml_title'] = $opt->unser('ml_title');

                $excursionOption = new Option();
                $excursionOption->fill([
                        'ru' => [
                            'title' => trim($sVar['ml_title']['ru'])
                        ],
                        'ge' => [
                            'title' => !empty($sVar['ml_title']['ka']) ? trim($sVar['ml_title']['ka']) : '',
                        ]
                    ]
                );

                $newExcursionOptGroup->options()->save($excursionOption);
            }
//            $optionObject = \AppOld\OptionsSublist::all();
//            foreach ($subList as $obj) {
//                dump($obj->unser('ml_title'));
//            }
        }

        $this->run1();
    }

    public function run1()
    {
        $newExcursionOptGroup = new OptionsGroup();
        $newExcursionOptGroup->excursions = true;
        $newExcursionOptGroup->fill([
            'ru' => [
                'title' => 'Включено в цену'
            ],
            'ge' => [
                'title' => 'შედის ფასი'
            ]
        ]);
        $newExcursionOptGroup->save();


        $options = [
            [
                'ru' => ['title' => 'Транспорт с кондиционером'],
                'ge' => ['title' => 'ტრანსპორტი კონდიციონერით']
            ],
            [
                'ru' => ['title' => 'Все трансферы по программе'],
                'ge' => ['title' => 'პროგრამის მიხედვით ყველა ტრანსფერი']
            ],
            [
                'ru' => ['title' => 'Аренда внедорожников'],
                'ge' => ['title' => 'ჯიპის დაქირავება']
            ],
            [
                'ru' => ['title' => 'Подъем к храму Гергети на внедорожниках'],
                'ge' => ['title' => 'ჯიპები ტაძრამდე ასვლა']
            ],
            [
                'ru' => ['title' => 'Сопровождение гида'],
                'ge' => ['title' => ' გიდის მომსახურება']
            ],
            [
                'ru' => ['title' => 'Услуги русскоязычного гида'],
                'ge' => ['title' => 'რუსულენოვან გიდის მომსახურება']
            ],
            [
                'ru' => ['title' => 'Экскурсия проводится на 2-х языках'],
                'ge' => ['title' => 'ტური ტარდება 2 ენაზე']
            ],
            [
                'ru' => ['title' => 'Билет на подъёмник'],
                'ge' => ['title' => 'ბილეთი საბაგიროზე']
            ],
            [
                'ru' => ['title' => 'Билет в музей'],
                'ge' => ['title' => 'მუზეუმის ბილეთი']
            ],
            [
                'ru' => ['title' => 'Билеты во все музеи'],
                'ge' => ['title' => 'ბილეთები ყველა მუზეუმში']
            ],
            [
                'ru' => ['title' => 'Все входные билеты по программе'],
                'ge' => ['title' => 'პროგრამის ყველა ბილეთი']
            ],
            [
                'ru' => ['title' => 'Билет в винодельню'],
                'ge' => ['title' => 'ბილეთი ღვინის ქარხანაში']
            ],
            [
                'ru' => ['title' => 'Прогулка на лодке'],
                'ge' => ['title' => 'ნავით გასეირნება']
            ],
            [
                'ru' => ['title' => 'Вода в автобусе 0.5 л'],
                'ge' => ['title' => 'წყალი ავტობუსში 0.5 ლ']
            ],
            [
                'ru' => ['title' => 'Холодные напитки'],
                'ge' => ['title' => 'ცივი სასმელები']
            ],
            [
                'ru' => ['title' => 'Питание'],
                'ge' => ['title' => 'კვება']
            ],
            [
                'ru' => ['title' => 'Питание не по программе'],
                'ge' => ['title' => 'საკვები პროგრამის დამატებით']
            ],
            [
                'ru' => ['title' => 'Ланч бокс'],
                'ge' => ['title' => 'სადილი ყუთში']
            ],
            [
                'ru' => ['title' => 'Пикник'],
                'ge' => ['title' => 'პიკნიკი']
            ],
            [
                'ru' => ['title' => 'Завтрак'],
                'ge' => ['title' => 'საუზმე']
            ],
            [
                'ru' => ['title' => 'Обед'],
                'ge' => ['title' => 'სადილი']
            ],
            [
                'ru' => ['title' => 'Ужин'],
                'ge' => ['title' => 'ვახშამი']
            ],
            [
                'ru' => ['title' => 'Вино'],
                'ge' => ['title' => 'ღვინო']
            ],
            [
                'ru' => ['title' => 'Вино дополнительно'],
                'ge' => ['title' => 'ღვინო დამატებით']
            ],
            [
                'ru' => ['title' => 'Дегустация вин'],
                'ge' => ['title' => 'ღვინის დეგუსტაცია']
            ],
            [
                'ru' => ['title' => 'Дегустация вина и чачи'],
                'ge' => ['title' => 'ღვინის და ჭაჭის დეგუსტაცია']
            ],
            [
                'ru' => ['title' => 'Интернет в пути'],
                'ge' => ['title' => 'ინტერნეტი გზაში']
            ],
            [
                'ru' => ['title' => 'Зарядное для Android/iPhone'],
                'ge' => ['title' => 'დდამტენი Android/iPhone']
            ],
            [
                'ru' => ['title' => 'Дождевики на случай дождя'],
                'ge' => ['title' => 'საწვიმარი']
            ],
            [
                'ru' => ['title' => 'Национальные костюмы для фотосессии'],
                'ge' => ['title' => 'ეროვნული კოსტიუმები']
            ],
            [
                'ru' => ['title' => 'Инструктор'],
                'ge' => ['title' => 'ინსტრუქტორი']
            ],
            [
                'ru' => ['title' => 'Услуги фотографа'],
                'ge' => ['title' => 'ფოტოგრაფის მომსახურება']
            ],
            [
                'ru' => ['title' => 'Размещение'],
                'ge' => ['title' => 'განთავსება']
            ],
            [
                'ru' => ['title' => 'Жильё'],
                'ge' => ['title' => 'საცხოვრებელი']
            ],
            [
                'ru' => ['title' => 'Личные расходы'],
                'ge' => ['title' => 'პირადი ხარჯები']
            ],
        ];

        foreach ($options as $opt) {
            $excursionOption = new Option();
            $excursionOption->fill($opt);
            $newExcursionOptGroup->options()->save($excursionOption);
        }

    }
}
