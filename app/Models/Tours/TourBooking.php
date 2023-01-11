<?php

namespace App\Models\Tours;


use App\BankPayment;
use App\Option;
use App\Order;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tours\TourBooking
 *
 * @property int $id
 * @property int $customer_id
 * @property int $tour_id
 * @property int $qty_adults
 * @property int $qty_kids
 * @property int $qty_additional
 * @property int|null $food_option_id
 * @property float|null $food_option_cost
 * @property bool $add_transfer
 * @property float|null $transfer_cost
 * @property bool $add_flight
 * @property float|null $flight_cost
 * @property \Illuminate\Support\Carbon $date_in
 * @property float $sub_total
 * @property float $prepay
 * @property float $tax
 * @property float $total
 * @property string $currency_code
 * @property int $currency_id
 * @property bool $confirmed
 * @property string|null $notes
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $partner_notes
 * @property bool $price_changed
 * @property \Illuminate\Support\Carbon|null $date_out
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\AccommodationBooking[] $accommodationBooking
 * @property-read \App\User $customer
 * @property-read \App\Option|null $food
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\TourBookingGuest[] $guests
 * @property-read \App\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BankPayment[] $payments
 * @property-read \App\Models\Tours\Tour $tour
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereAddFlight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereAddTransfer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereDateIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereDateOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereFlightCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereFoodOptionCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereFoodOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking wherePartnerNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking wherePrepay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking wherePriceChanged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereQtyAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereQtyAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereQtyKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereSubTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereTransferCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBooking whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TourBooking extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'date_in',
        'date_out'
    ];

    protected $fillable = [
        'date_in',
        'date_out',

        'sub_total', //?
        //доплата на месте
        'prepay', //предоплата
        'tax', //ндс (плательщик или не плательщик)
        'total', //итог
        'transaction_fee', //процент банка

        'hotel',
        'accommodation_variant',
        'kids_ages',

        'partner_notes',
        'price_changed',
        'confirmed'
    ];

    //'created', 'confirmed', 'payed', 'canceled'

    public function tour()
    {
        return $this->belongsTo(Tour::class)->withTrashed();
    }

    public function accommodationBooking()
    {
        return $this->hasMany(AccommodationBooking::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Option::class, 'food_option_id');
    }

    public function guests()
    {
        return $this->hasMany(TourBookingGuest::class);
    }

    public function payments()
    {
        return $this->morphMany(BankPayment::class, 'service');
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'booking');
    }

//    public function currency()
//    {
//        return $this->belongsTo(Currency::class, 'food_option_id');
//    }
}
