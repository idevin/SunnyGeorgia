<?php

use App\Models\Hotels\HotelBooking;
use App\Models\Hotels\Room;
use App\Models\Hotels\RoomBooking;
use Illuminate\Database\Seeder;

class HotelBookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $hotels = \App\Hotel::all();
        foreach ($hotels as $hotel) {

            $rooms = $hotel->rooms()->get();

            $carbonCurrent = \Carbon\Carbon::now()->addDay()->startOfDay();
            $carbonFuture = \Carbon\Carbon::now()->addYear()->startOfDay();

            while ($carbonCurrent->diffInDays($carbonFuture, false) > 0) {
                $available = $faker->boolean(30);
                if ($available) {

                    $book = [];
                    foreach ($rooms as $room) {
                        if (rand(0, 1)) {
                            $book[$room->id] = rand(1, $room->amount);
                        }
                    }
                    if (!empty($book)) {
                        $totalPrice = 0;
                        $hotelBooking = new HotelBooking();
                        $hotelBooking->user_id = 1;
                        $hotelBooking->date_in = $carbonCurrent->toDateString();
                        $hotelBooking->date_out = (new \Carbon\Carbon($carbonCurrent))->addDays(rand(1, 15));
                        $hotelBooking->tax_total = 0;
                        $hotelBooking->price_total = 0;
                        $hotelBooking->notes = 0;

                        $hotel->bookings()->save($hotelBooking);

                        foreach ($book as $roomId => $roomAmount) {
                            if ($roomAmount > 0) {

                                $room = Room::find($roomId);
                                $roomBooking = new RoomBooking();
                                $roomBooking->room_id = $room->id;
                                $roomBooking->hotel_booking_id = $hotelBooking->id;
                                $roomBooking->hotel_id = $hotel->id;
                                $roomBooking->amount = $roomAmount;
                                $roomBooking->price_total = $room->price * $roomAmount;
                                $roomBooking->tax_total = 23;
                                $roomBooking->notes = $faker->text();
                                $roomBooking->save();
                                $totalPrice += $roomBooking->price_total;
                            }
                        }
                        $hotelBooking->price_total = $totalPrice;
                        $hotelBooking->save();
                    }

                    dump('booked');
                }
                $carbonCurrent->addDay();

            }

        }
    }
}
