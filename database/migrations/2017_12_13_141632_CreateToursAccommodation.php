<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursAccommodation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_id');
            $table->integer('thumb_id')->nullable();

            $table->double('price_adult', 14, 2)->nullable();
            $table->double('price_kid', 14, 2)->nullable();
            $table->double('price_additional', 14, 2)->nullable();

            $table->integer('currency_id')->nullable();

            $table->boolean('published')->default(false);
            $table->integer('adults')->default(0);
            $table->integer('kids')->default(0)->nullable();
            $table->integer('add_beds')->default(0)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('accommodation_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_id')->unsigned();
            $table->string('locale', 10)->index();
            $table->string('hotel')->nullable();
            $table->string('room')->nullable();

            $table->unique(['accommodation_id', 'locale']);
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
        Schema::create('accommodation_media', function (Blueprint $table) {
            $table->integer('accommodation_id');
            $table->integer('media_id');

            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });

        Schema::create('accommodation_availabilities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_id');
            $table->date('date');
            $table->integer('amount');
            $table->integer('days_cancel')->nullable();
            $table->integer('days_book_min')->default(1);

            $table->decimal('price_special_gel', 14, 2)->nullable();
            $table->decimal('price_special_usd', 14, 2)->nullable();
            $table->decimal('discount_percent', 14, 2)->default(0);

            $table->timestamps();

            $table->unique(['date', 'accommodation_id']);
            $table->index(['accommodation_id']);

        });
//        accommodation

        Schema::create('accommodation_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_booking_id');
            $table->integer('accommodation_id');

            $table->date('date_in');

            $table->integer('qty_adults')->default(0);
            $table->integer('qty_kids')->default(0);
            $table->integer('qty_additional')->default(0);

            $table->double('amount_adults')->default(0);
            $table->double('amount_kids')->default(0);
            $table->double('amount_additional')->default(0);

            $table->boolean('confirmed')->default(false);

            $table->index(['date_in']);

            $table->timestamps();
        });
        Schema::create('tour_booking_guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tour_booking_id');
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->boolean('child')->default(false);
            $table->integer('age')->nullable();

            $table->timestamps();
        });
        Schema::create('accommodation_option', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('accommodation_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_option');
        Schema::dropIfExists('tour_booking_guests');
        Schema::dropIfExists('accommodation_booking_guests');
        Schema::dropIfExists('accommodation_bookings');
        Schema::dropIfExists('accommodation_availabilities');
        Schema::dropIfExists('accommodation_media');
        Schema::dropIfExists('accommodation_translations');
        Schema::dropIfExists('accommodations');
    }
}
