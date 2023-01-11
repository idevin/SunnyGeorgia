<?php

namespace App\Models\Hotels;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hotels\RoomsAvailability
 *
 * @property int $id
 * @property int $room_id
 * @property string $date
 * @property int $amount
 * @property bool $available
 * @property int|null $days_cancel
 * @property int $days_book_min
 * @property float $price_special
 * @property float $discount_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Hotels\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereDaysBookMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereDaysCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability wherePriceSpecial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\RoomsAvailability whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomsAvailability extends Model
{
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

//    public function hotel()
//    {
//        return $this->hasManyThrough(Hotel::class, Room::class);
//    }

}
