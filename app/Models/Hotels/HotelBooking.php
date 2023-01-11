<?php

namespace App\Models\Hotels;


use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hotels\HotelBooking
 *
 * @property int $id
 * @property int $hotel_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date_in
 * @property \Illuminate\Support\Carbon $date_out
 * @property float $tax_total
 * @property float $price_total
 * @property string $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hotels\Hotel $hotel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotels\RoomBooking[] $roomsBooking
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereDateIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereDateOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking wherePriceTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereTaxTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelBooking whereUserId($value)
 * @mixin \Eloquent
 */
class HotelBooking extends Model
{

    protected $dates = ['date_in', 'date_out'];

    public function roomsBooking()
    {
        return $this->hasMany(RoomBooking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);

    }
}
