<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdminPool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table){
            $table->boolean('sys_emails')->default(0);
        });

        $user = \App\User::query()->whereEmail('admin@sunnygeorgia.travel')->first();

        $data =[
            'email' => 'admin@sunnygeorgia.travel',
            'first_name' => 'Admin',
            'last_name' => 'Sunny Georgia',
            'password' => bcrypt(str_random(30)),
            'email_verified' => 1,
            'sys_emails' => 1
        ];

        if(!$user) {
            $user = \App\User::query()->firstOrCreate($data);
            $user->attachRoles(['user', 'partner', 'admin']);
        } else {
            $user->update($data);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
