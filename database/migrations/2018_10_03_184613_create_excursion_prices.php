<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Excursions\Excursion;

class CreateExcursionPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('excursions', function (Blueprint $table) {
            $table->string('type')->default("person");
        });

        Schema::create('excursion_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('excursion_id');
            $table->string('price_type');
            $table->double('price', 14, 2)->nullable();
            $table->integer('price_from')->nullable();
            $table->integer('price_to')->nullable();
            $table->timestamps();
        });

        $this->run();
    }


    public function run()
    {
        $excursions = Excursion::all();
        foreach ($excursions as $excursion) {
            $excursion->type = 'person';

            if ($excursion->price_excursion) {
                $excursion->type = 'group';
                $price_child = $excursion->price_kid;
                $price_baby = $excursion->price_kid;
            } else {
                $excursion->price_excursion = null;
                if ($excursion->price_kid) {
                    $price_child = $excursion->price_kid;
                    $price_baby = $excursion->price_kid;
                } else {
                    $price_child = $excursion->price_adult;
                    $price_baby = 0;
                }
            }
            $excursion->save();

            $prices = [
                [
                    "price_type" => "adult",
                    "price" => $excursion->price_adult
                ],
                [
                    "price_type" => "baby",
                    "price" => $price_baby,
                    "price_from" => 0,
                    "price_to" => 6
                ],
                [
                    "price_type" => "child",
                    "price" => $price_child,
                    "price_from" => 6,
                    "price_to" => 14
                ],
                [
                    "price_type" => "group",
                    "price" => $excursion->price_excursion,
                    "price_from" => 2,
                    "price_to" => null
                ],
            ];
            foreach ($prices as $price) {
                $excursion->prices()->create($price);
            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excursion_prices');

        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
