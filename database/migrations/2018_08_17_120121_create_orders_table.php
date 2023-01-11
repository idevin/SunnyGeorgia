<?php

use App\Models\Excursions\ExcursionBooking;
use App\Models\Tours\TourBooking;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('booking');

            $table->integer('customer_id');
//            $table->integer('partner_id');
//            $table->integer('partner_user_id');

            $table->timestamps();
            $table->softDeletes();
        });

        $excursionBookings = ExcursionBooking::all();
        $tourBookings = TourBooking::all();

        $orders = $tourBookings->concat($excursionBookings)
            ->sortBy('created_at');

        foreach ($orders as $order) {
            $newOrder = new \App\Order();

            $newOrder->booking_type = get_class($order);
            $newOrder->booking_id = $order->id;
            $newOrder->customer_id = $order->customer_id;
            $newOrder->created_at = $order->created_at;
            $newOrder->updated_at = $order->updated_at;
            $newOrder->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
