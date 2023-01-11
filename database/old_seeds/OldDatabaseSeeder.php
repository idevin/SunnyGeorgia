<?php

use Illuminate\Database\Seeder;

class OldDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //runned from migration
//        $this->call(CurrenciesSeeder::class);
//        $this->call(RolesTableSeeder::class);
//        $this->call(LanguagesTableSeeder::class);
        $this->call(UsersSeeder::class);

        $this->call(CitiesTableSeeder::class);
        $this->call(HotelOptionsSeeder::class);
        $this->call(ExcursionsOptionsSeeder::class);
        $this->call(ExcursionsSeeder::class);
        $this->call(TourOptionsSeeder::class);
        $this->call(ToursFakeSeeder::class);

//        $this->call(HotelsSeeder::class);
    }
}
