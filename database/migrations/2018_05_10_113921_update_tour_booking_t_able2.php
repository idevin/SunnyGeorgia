<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTourBookingTAble2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->date('date_out')->nullable();
        });


        $booking = \App\Models\Tours\TourBooking::all()->load('tour');
        foreach ($booking as $book) {

//            $dateOut;
            $tour = $book->tour;

            if ($tour->days > $tour->nights) {
                $totalDays = $tour->days + 2;
            } elseif ($tour->days == $tour->nights) {
                $totalDays = $tour->days + 1;
            } elseif ($tour->days < $tour->nights) {
                $totalDays = $tour->days;
            }

            $book->date_out = (new Carbon($book->date_in))->addDays($totalDays);
            $book->save();
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tour_bookings', function (Blueprint $table) {
            $table->dropColumn('date_out');
        });
    }
}
