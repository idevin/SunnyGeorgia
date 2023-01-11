<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner = new Role();
        $owner->name = 'admin';
        $owner->display_name = 'Administrator';
        $owner->description = '';
        $owner->save();

        $owner = new Role();
        $owner->name = 'user';
        $owner->display_name = 'User';
        $owner->description = '';
        $owner->save();

        $owner = new Role();
        $owner->name = 'partner';
        $owner->display_name = 'Partner';
        $owner->description = '';
        $owner->save();
    }
}