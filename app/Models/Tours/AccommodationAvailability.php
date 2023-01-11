<?php

namespace App\Models\Tours;


use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tours\AccommodationAvailability
 *
 * @property int $id
 * @property int $accommodation_id
 * @property string $date
 * @property int $amount
 * @property int|null $days_cancel
 * @property int $days_book_min
 * @property float|null $price_special_gel
 * @property float|null $price_special_usd
 * @property float $discount_percent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereAccommodationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereDaysBookMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereDaysCancel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability wherePriceSpecialGel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability wherePriceSpecialUsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationAvailability whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AccommodationAvailability extends Model
{
    use CacheQueryBuilder;

    protected $fillable = [
        'accommodation_id',
        'date',
        'amount',
        'discount_percent',
        'price_special_gel'
    ];
}
