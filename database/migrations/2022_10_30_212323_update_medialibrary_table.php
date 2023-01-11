<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_library', function (Blueprint $table) {
            $table->bigIncrements('id')->change();

            $table->unsignedBigInteger('size')->change();
            $table->index('order_column');

            $table->json('generated_conversions')->default(json_encode (new \stdClass()));
            $table->string('conversions_disk')->nullable();
            $table->uuid('uuid')->nullable()->unique();
        });
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
};
