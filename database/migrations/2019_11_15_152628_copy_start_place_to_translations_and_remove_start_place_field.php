<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CopyStartPlaceToTranslationsAndRemoveStartPlaceField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->run();

        Schema::table('excursions', function (Blueprint $table) {
            $table->dropColumn('start_place');
        });
    }

    public function run()
    {
        $excursions = \Illuminate\Support\Facades\DB::table('excursions')
          ->where('reviewed', '=', true)->get();
        foreach ($excursions as $item) {
            if(isset($item->start_place) && !is_null($item->start_place)) {
                $excursion = \App\Models\Excursions\Excursion::withTrashed()->where('id', $item->id)->firstOrFail();
                if($excursion->id) {
                  dump($item->start_place, $excursion->id, $excursion->start_place);
			            $excursion->translate('ru')->start_place = $item->start_place;
                	$excursion->save();
		            }
            } else {
              dump($item->id);
            }
        }
    }
}
