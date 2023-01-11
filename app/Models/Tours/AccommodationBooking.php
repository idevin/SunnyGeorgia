<?php

namespace App\Models\Tours;


use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tours\AccommodationBooking
 *
 * @property int $id
 * @property int $tour_booking_id
 * @property int $accommodation_id
 * @property string $date_in
 * @property int $qty_adults
 * @property int $qty_kids
 * @property int $qty_additional
 * @property float $amount_adults
 * @property float $amount_kids
 * @property float $amount_additional
 * @property bool $confirmed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Tours\Accommodation $accommodation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereAccommodationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereAmountAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereAmountAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereAmountKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereDateIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereQtyAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereQtyAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereQtyKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereTourBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationBooking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccommodationBooking extends Model
{
    use CacheQueryBuilder;

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
