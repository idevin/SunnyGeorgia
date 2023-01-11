<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activations', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });
        Schema::create('user_mobile', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('token')->index();
            $table->integer('attempts')->default(0);
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_mobile');
        Schema::dropIfExists('user_activations');
    }
}
