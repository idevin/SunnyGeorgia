<?php

namespace App\Models\Hotels;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hotels\RoomBooking
 *
 * @property int $id
 * @property int $hotel_booking_id
 * @property int $hotel_id
 * @property int $room_id
 * @property int $amount
 * @property float $price_total
 * @property float $tax_total
 * @property string $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hotels\HotelBooking $hotelBooking
 * @property-read \App\Models\Hotels\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereHotelBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking wherePriceTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereTaxTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomBooking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomBooking extends Model
{

    public function hotelBooking()
    {
        return $this->belongsTo(HotelBooking::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
