<?php

namespace App\Models\Excursions;


use App\BankPayment;
use App\Order;
use App\User;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Excursions\ExcursionBooking
 *
 * @property int $id
 * @property int $excursion_id
 * @property int $excursion_availability_id
 * @property int $customer_id
 * @property Carbon $date_time_in
 * @property Carbon $date_in
 * @property string $time_in
 * @property string|null $date_out
 * @property int $qty_adults
 * @property int $qty_kids
 * @property float $sub_total
 * @property float $prepay
 * @property float $tax
 * @property float $total
 * @property string $currency_code
 * @property int $currency_id
 * @property bool $confirmed
 * @property string|null $customer_notes
 * @property string|null $partner_notes
 * @property bool $price_changed
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $group_pid
 * @property int $qty_baby
 * @property int $qty_child
 * @property-read User $customer
 * @property-read Excursion $excursion
 * @property-read Order $order
 * @property-read Collection|BankPayment[] $payments
 * @method static Builder|ExcursionBooking newModelQuery()
 * @method static Builder|ExcursionBooking newQuery()
 * @method static Builder|ExcursionBooking query()
 * @method static Builder|ExcursionBooking whereConfirmed($value)
 * @method static Builder|ExcursionBooking whereCreatedAt($value)
 * @method static Builder|ExcursionBooking whereCurrencyCode($value)
 * @method static Builder|ExcursionBooking whereCurrencyId($value)
 * @method static Builder|ExcursionBooking whereCustomerId($value)
 * @method static Builder|ExcursionBooking whereCustomerNotes($value)
 * @method static Builder|ExcursionBooking whereDateIn($value)
 * @method static Builder|ExcursionBooking whereDateOut($value)
 * @method static Builder|ExcursionBooking whereDateTimeIn($value)
 * @method static Builder|ExcursionBooking whereExcursionAvailabilityId($value)
 * @method static Builder|ExcursionBooking whereExcursionId($value)
 * @method static Builder|ExcursionBooking whereGroupPid($value)
 * @method static Builder|ExcursionBooking whereId($value)
 * @method static Builder|ExcursionBooking wherePartnerNotes($value)
 * @method static Builder|ExcursionBooking wherePrepay($value)
 * @method static Builder|ExcursionBooking wherePriceChanged($value)
 * @method static Builder|ExcursionBooking whereQtyAdults($value)
 * @method static Builder|ExcursionBooking whereQtyBaby($value)
 * @method static Builder|ExcursionBooking whereQtyChild($value)
 * @method static Builder|ExcursionBooking whereQtyKids($value)
 * @method static Builder|ExcursionBooking whereStatus($value)
 * @method static Builder|ExcursionBooking whereSubTotal($value)
 * @method static Builder|ExcursionBooking whereTax($value)
 * @method static Builder|ExcursionBooking whereTimeIn($value)
 * @method static Builder|ExcursionBooking whereTotal($value)
 * @method static Builder|ExcursionBooking whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ExcursionBooking extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'date_time_in',
        'date_in',
    ];

    protected $fillable = [
        'date_in',
        'date_out',
        'sub_total',
        'prepay',
        'tax',
        'total',
        'transaction_fee',
        'partner_notes',
        'price_changed',
        'confirmed',
        'status'
    ];

    //'created', 'confirmed', 'payed', 'canceled'

    public function excursion()
    {
        return $this->belongsTo(Excursion::class)->withTrashed();
    }


    /**
     * @return BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->morphMany(BankPayment::class, 'service');
    }

    public function order()
    {
        return $this->morphOne(Order::class, 'booking');
    }

}
