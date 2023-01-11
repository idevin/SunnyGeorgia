<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optionables', function (Blueprint $table) {
            $table->integer('option_id');
            $table->morphs('optionable');
            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();
            $table->boolean('free')->default(true);
        });

        $hopt = DB::table('hotel_option')->get();
        foreach ($hopt as $opt) {

            DB::table('optionables')->insert([
                'optionable_type' => App\Models\Hotels\Hotel::class,
                'optionable_id' => $opt->hotel_id,
                'value' => $opt->value,
                'price' => $opt->price,
                'free' => $opt->price ? false : true,
                'option_id' => $opt->option_id,
            ]);
            echo '+';
        }

        $hopt = DB::table('option_room')->get();
        foreach ($hopt as $opt) {

            DB::table('optionables')->insert([
                'optionable_type' => App\Models\Hotels\Room::class,
                'optionable_id' => $opt->room_id,
                'value' => $opt->value,
                'price' => $opt->price,
                'free' => $opt->price ? false : true,
                'option_id' => $opt->option_id,
            ]);
            echo '+';
        }

        $hopt = DB::table('excursion_option')->get();
        foreach ($hopt as $opt) {

            DB::table('optionables')->insert([
                'optionable_type' => App\Models\Excursions\Excursion::class,
                'optionable_id' => $opt->excursion_id,
                'value' => $opt->value,
                'price' => $opt->price,
                'free' => $opt->free,
                'option_id' => $opt->option_id,
            ]);
            echo '+';
        }
        $hopt = DB::table('option_tour')->get();
        foreach ($hopt as $opt) {

            DB::table('optionables')->insert([
                'optionable_type' => App\Models\Tours\Tour::class,
                'optionable_id' => $opt->tour_id,
                'value' => $opt->value,
                'price' => $opt->price,
                'free' => $opt->free,
                'option_id' => $opt->option_id,
            ]);
            echo '+';
        }
        $hopt = DB::table('accommodation_option')->get();
        foreach ($hopt as $opt) {

            DB::table('optionables')->insert([
                'optionable_type' => App\Models\Tours\Accommodation::class,
                'optionable_id' => $opt->accommodation_id,
                'value' => $opt->value,
                'price' => $opt->price,
                'free' => $opt->price ? false : true,
                'option_id' => $opt->option_id,
            ]);
            echo '+';
        }


        Schema::dropIfExists('hotel_option');
        Schema::dropIfExists('excursion_option');
        Schema::dropIfExists('option_room');
        Schema::dropIfExists('option_tour');
        Schema::dropIfExists('accommodation_option');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('hotel_option', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('hotel_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();
            $table->boolean('free')->default(true);

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
        });
        Schema::create('option_room', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('room_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();
            $table->boolean('free')->default(true);

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('cascade');
        });
        Schema::create('excursion_option', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('excursion_id');

            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();
            $table->boolean('free')->default(true);

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('excursion_id')->references('id')->on('excursions')->onDelete('cascade');
        });

        Schema::create('option_tour', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('tour_id');

            $table->boolean('free')->default(true);
            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
        Schema::create('accommodation_option', function (Blueprint $table) {
            $table->integer('option_id');
            $table->integer('accommodation_id');

            $table->boolean('free')->default(true);
            $table->string('value')->nullable();
            $table->double('price', 2, 14)->nullable();

            $table->foreign('option_id')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->onDelete('cascade');
        });
        $optionables = DB::table('optionables')->get();

        foreach ($optionables as $opt) {

            $optionableTable = null;
            $field = '';


            switch ($opt->optionable_type) {
                case App\Models\Tours\Tour::class:
                    $optionableTable = 'option_tour';
                    $field = 'tour_id';
                    break;
                case App\Models\Hotels\Room::class:
                    $optionableTable = 'option_room';
                    $field = 'room_id';
                    break;
                case App\Models\Excursions\Excursion::class:
                    $optionableTable = 'excursion_option';
                    $field = 'excursion_id';
                    break;
                case App\Models\Hotels\Hotel::class:
                    $optionableTable = 'hotel_option';
                    $field = 'hotel_id';
                    break;
                case App\Models\Tours\Accommodation::class:
                    $optionableTable = 'accommodation_option';
                    $field = 'accommodation_id';
                    break;

            }

            DB::table($optionableTable)->insert([
                $field => $opt->optionable_id,
                'value' => $opt->value,
                'price' => $opt->price,
                'free' => $opt->free,
                'option_id' => $opt->option_id,
            ]);
        }

        Schema::dropIfExists('optionables');
    }
}
