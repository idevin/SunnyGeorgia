<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('display_name')->nullable();
            $table->string('email')->unique();
            $table->boolean('email_verified')->default(false);
            $table->string('password');
            $table->string('mobile_number')->nullable();
            $table->boolean('mobile_confirmed')->default(false);
            $table->date('birthday')->nullable();
            $table->integer('avatar_id')->nullable();
            $table->string('social_link')->nullable();
            $table->string('description')->nullable();
            $table->string('country')->default('')->nullable();
            $table->string('id_number')->nullable();

            $table->string('p_address')->nullable();
            $table->string('p_city')->nullable();
            $table->string('p_country')->nullable();
            $table->string('p_postcode')->nullable();
            $table->string('locale', 10)->default('ru');
            $table->string('currency', 10)->default(config('app.currency'));

            $table->rememberToken();
            $table->dateTime('last_visit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
