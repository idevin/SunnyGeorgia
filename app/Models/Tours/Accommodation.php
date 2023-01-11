<?php

namespace App\Models\Tours;


use App\Currency;
use App\Media;
use App\Option;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Carbon\Carbon;
use Astrotomic\Translatable\Translatable;
use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Tours\Accommodation
 *
 * @property int $id
 * @property int $tour_id
 * @property int|null $thumb_id
 * @property float|null $price_adult
 * @property float|null $price_kid
 * @property float|null $price_additional
 * @property int|null $currency_id
 * @property bool $published
 * @property int $adults
 * @property int|null $kids
 * @property int|null $add_beds
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\AccommodationAvailability[] $availability
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\AccommodationAvailability[] $availabilityFuture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\AccommodationBooking[] $bookings
 * @property-read \App\Currency|null $currency
 * @property-read mixed $local_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read \App\Media|null $thumb
 * @property-read \App\Models\Tours\Tour $tour
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\AccommodationTranslation[] $translations
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tours\Accommodation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereAddBeds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation wherePriceAdditional($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation wherePriceAdult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation wherePriceKid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereThumbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereTourId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\Accommodation withTranslation()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tours\Accommodation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Tours\Accommodation withoutTrashed()
 * @mixin \Eloquent
 */
class Accommodation extends Model  implements TranslatableContract
{
    use Translatable, SoftDeletes;

    use CacheQueryBuilder;

    public $translatedAttributes = ['hotel', 'room'];

    public $fillable = [
        'kids',
        'adults',
        'add_beds',
        'currency_id',
        'price_adult',
        'price_kid',
        'price_additional',
    ];

    public function images()
    {
        return $this->belongsToMany(Media::class);
    }

    public function thumb()
    {
        return $this->belongsTo(Media::class, 'thumb_id');
    }

    public function bookings()
    {
        return $this->hasMany(AccommodationBooking::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function availability()
    {
        return $this->hasMany(AccommodationAvailability::class);
    }

    public function availabilityFuture()
    {
        return $this->hasMany(AccommodationAvailability::class)->where('date', '>=', Carbon::now());
    }

    public function available(Carbon $dateFrom, Carbon $dateTo)
    {
        return $this->hasMany(AccommodationAvailability::class)->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()]);
    }

    public function options()
    {
        return $this->morphToMany(Option::class, 'optionable')
            ->withPivot('value', 'price', 'free');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getLocalPriceAttribute()
    {
        return $this->attributes['local_price'] = round(currency($this->price, $this->currency->code, currency()->getUserCurrency(), false), 2);
    }

//    public function getPriceAdultAttribute($value)
//    {
//        $tourCostService = new TourCostService;
//        $tourCostService->
//        return ucfirst($value);
//    }
}
