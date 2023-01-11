<?php

namespace App;


use App\Models\Tours\TourBooking;
use Illuminate\Database\Eloquent\Model;

/**
 * App\BankPayment
 *
 * @property int $id
 * @property string $system
 * @property string $transaction_id
 * @property int $amount
 * @property int $currency_id
 * @property string $currency_code
 * @property string $status
 * @property mixed|null $data
 * @property int $service_id
 * @property string $service_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $service
 * @property-read \App\Models\Tours\TourBooking $tourBooking
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BankPayment whereUserId($value)
 * @mixin \Eloquent
 */
class BankPayment extends Model
{

    public function tourBooking()
    {
        return $this->belongsTo(TourBooking::class, 'service_id', 'id');
    }

    public function service()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
