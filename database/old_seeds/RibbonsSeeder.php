<?php

use Illuminate\Database\Seeder;

class RibbonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ribbons = [
            ['ru' => ['title' => 'Лучшая цена']],
            ['ru' => ['title' => '-25%'], 'type' => 'success'],
            ['ru' => ['title' => '-50%'], 'type' => 'warning'],
        ];

        foreach ($ribbons as $ribbon) {
            $ribbonM = new \App\Ribbon();
            $ribbonM->fill($ribbon);
            $ribbonM->save();
        }

    }
}
