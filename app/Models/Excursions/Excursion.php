<?php

namespace App\Models\Excursions;

use App\Currency;
use App\Option;
use App\Partner;
use App\Place;
use App\Ribbon;
use App\Traits\HasGeneratedReviews;
use App\Traits\Utils;
use App\User;
use Artisanry\Reviewable\Traits\HasReviews;
use Carbon\Carbon;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Eloquent;
use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**
 * App\Models\Excursions\Excursion
 *
 * @property mixed title
 * @property int $id
 * @property int $user_id
 * @property int $place_id
 * @property int|null $thumb_id
 * @property bool $published
 * @property bool $calendar_use
 * @property float|null $duration
 * @property int $min_people
 * @property int|null $max_people
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $reviewed
 * @property string|null $deleted_at
 * @property string|null $start_place
 * @property array|null $start_time
 * @property int $currency_id
 * @property float|null $price_kid
 * @property float|null $price_adult
 * @property float|null $price_excursion
 * @property float|null $lat
 * @property float|null $long
 * @property string|null $route_length
 * @property int|null $free_cancel_before
 * @property int $score
 * @property string|null $currency_code
 * @property string $type
 * @property bool $noindex_ru
 * @property bool $noindex_ge
 * @property bool $noindex_en
 * @property int $commission
 * @property int|null $commission_proposal
 * @property-read Collection|ExcursionAvailability[] $availabilities
 * @property-read Collection|ExcursionAvailability[] $availabilityFuture
 * @property-read Collection|ExcursionBooking[] $bookings
 * @property-read Currency $currency
 * @property-read mixed $price
 * @property-read Collection|\App\Media[] $images
 * @property-read Collection|Option[] $options
 * @property-read Collection|Option[] $paidOptions
 * @property-read Partner $partner
 * @property-read Place $place
 * @property-read Collection|ExcursionPrice[] $prices
 * @property-read Collection|ExcursionPrice[] $prices_min
 * @property-read Collection|Review[] $reviews
 * @property-read Collection|Ribbon[] $ribbons
 * @property-read \App\Media|null $thumb
 * @property-read Collection|ExcursionTranslation[] $translations
 * @property-read User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion notTranslatedIn($locale = null)
 * @method static Builder|Excursion onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereCalendarUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereCommissionProposal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereFreeCancelBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereMaxPeople($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereMinPeople($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereNoindexEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereNoindexGe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereNoindexRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion wherePriceAdult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion wherePriceExcursion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion wherePriceKid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereRouteLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereStartPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereThumbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Excursion withTranslation()
 * @method static Builder|Excursion withTrashed()
 * @method static Builder|Excursion withoutTrashed()
 */
class Excursion extends Model implements HasMedia, TranslatableContract
{
    use Translatable, SoftDeletes, Utils, HasReviews, HasGeneratedReviews, InteractsWithMedia;

    use CacheQueryBuilder;

    public array $translatedAttributes = [
        'slug',
        'title',
        'intro',
        'description',
        'meta_title',
        'meta_description',
        'start_place',
    ];
    protected $casts = [
        'start_time' => 'array',
    ];
    protected $fillable = [
        'free_cancel_before',
        'place_id',
        'published',
        'calendar_use',
        'duration',
        'min_people',
        'max_people',
        'start_time',
        'currency_id',
        'price_kid',
        'price_adult',
        'price_excursion',
        'type',
        'published',
        'route_length',
        'lat',
        'long',
        'score',
        'noindex_ru',
        'noindex_en',
        'noindex_ka',
        'commission',
        'commission_proposal',
        'prepay',
    ];

    protected $hidden = ['commission_proposal'];

    protected $appends = [
        'new_thumb', 'average_rating'
    ];

    public function getNewThumbAttribute(): array
    {
        if (!$this->media->isEmpty()) {
            $mainImage = $this->getMedia('excursions')->first(function ($item) {
                return $item->hasCustomProperty('main');
            });
            if ($mainImage) {
                return [
                    'jpg' => $mainImage->getUrl('thumb'),
                    'webp' => $mainImage->getUrl('thumb-webp'),
                    'alt' => $mainImage->getCustomProperty('alt', $this->title)
                ];
            } else {
                if($fMedia = $this->getFirstMedia('excursions')) {
                    return [
                        'jpg' => $this->getFirstMediaUrl('excursions', 'thumb'),
                        'webp' => $this->getFirstMediaUrl('excursions', 'thumb-webp'),
                        'alt' => $fMedia->getCustomProperty('alt', $this->title)
                    ];
                }
            }
        }
        return [
            'jpg' => '/static/images/assets/cards/card1.jpg',
            'webp' => '/static/images/assets/cards/card1.jpg',
            'alt' => $this->title
        ];
    }

    public function bookings()
    {
        return $this->hasMany(ExcursionBooking::class);
    }

    public function options()
    {
        return $this->morphToMany(Option::class, 'optionable')
            ->withPivot('value', 'price', 'free')
            ->orderBy('option_id');
    }

    public function paidOptions()
    {
        return $this->morphToMany(Option::class, 'optionable')
            ->join('options_groups', 'options_groups.id', '=', 'options.options_group_id')
            ->where('options_groups.price', '=', true)
            ->withPivot('value', 'price', 'free');
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function types()
    {
        return $this->belongsToMany(ExcursionType::class, 'excursion_excursion_type');
    }

    public function prices()
    {
        return $this->hasMany(ExcursionPrice::class);
    }

    public function availabilities()
    {
        return $this->hasMany(ExcursionAvailability::class);
    }

    public function available($time, Carbon $dateFrom, Carbon $dateTo)
    {
        return $this->hasMany(ExcursionAvailability::class)->where('time', $time)->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()]);
    }

    public function availabilityFuture()
    {
        return $this->hasMany(ExcursionAvailability::class)
            ->where('date', '>=', Carbon::now());
    }

    public function getActualAvailabilities($hours = 3)
    {
        // нельзя бронировать за $hours до отправления

        $availabilities = $this->availabilityFuture->groupBy('date');

        $today = Carbon::now()->toDateString();
        if (isset($availabilities[$today])) {
            $bookBefore = Carbon::now()->addHours($hours);
            $availabilities[$today] = $availabilities[$today]
                ->reject(function ($item) use ($bookBefore) {
                    $excursionTime = new Carbon($item->date . ' ' . $item->time);
                    return $excursionTime->lessThanOrEqualTo($bookBefore);
                })
                // the keys reset to consecutive integers
                ->values();
            if (!$availabilities[$today]->count()) {
                $availabilities->forget($today);
            }
        }

        return $availabilities;
    }

    public function availableTimes()
    {
        return $this->hasMany(ExcursionAvailability::class)
            ->orderBy('time')
            ->select('time')
            ->groupBy('time')
            ->pluck('time');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'user_id', 'user_id', User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ribbon()
    {
        return $this->belongsTo(Ribbon::class);
    }

    public function getMetaTitle()
    {
        return ($this->meta_title) ? $this->meta_title : str_title($this->title);
    }

    public function getMetaDesc()
    {
        return ($this->meta_description) ? $this->meta_description : str_limit($this->intro, 255);
    }

    public function getAverageRatingAttribute()
    {
        $rating = $this->getRating();
        $generatedRating = $this->getGeneratedRating();
        if ($rating && $generatedRating) {
            return ($rating + $generatedRating) / 2;
        } else {
            if ($rating) return $rating;
            if ($generatedRating) return $generatedRating;
            return 0;
        }
    }

    public function getRating(): float
    {
        return round($this->reviews()->where('published', true)->avg('rating'));
    }

    public function getGeneratedRating(): float
    {
        return round($this->generatedReviews()->where('published', true)->avg('rating'));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->acceptsFile(function (File $file) {
                return $file->mimeType === 'image/jpg' ||
                    $file->mimeType === 'image/jpeg' ||
                    $file->mimeType === 'image/png';
            })
            ->useDisk('excursions');
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb-webp')
            ->fit(Manipulations::FIT_CROP, 230, 230)
            ->sharpen(3)
            ->format(Manipulations::FORMAT_WEBP);
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 230, 230)
            ->sharpen(3)
            ->format(Manipulations::FORMAT_JPG);

        $this->addMediaConversion('slider-big-webp')
            ->fit(Manipulations::FIT_CROP, 825, 406)
            ->format(Manipulations::FORMAT_WEBP);
        $this->addMediaConversion('slider-big')
            ->fit(Manipulations::FIT_CROP, 825, 406)
            ->format(Manipulations::FORMAT_JPG);

        $this->addMediaConversion('slider-med-webp')
            ->fit(Manipulations::FIT_CROP, 690, 406)
            ->format(Manipulations::FORMAT_WEBP);
        $this->addMediaConversion('slider-med')
            ->fit(Manipulations::FIT_CROP, 690, 406)
            ->format(Manipulations::FORMAT_JPG);

        $this->addMediaConversion('slider-small-webp')
            ->fit(Manipulations::FIT_CROP, 510, 406)
            ->format(Manipulations::FORMAT_WEBP);
        $this->addMediaConversion('slider-small')
            ->fit(Manipulations::FIT_CROP, 510, 406)
            ->format(Manipulations::FORMAT_JPG);

        $this->addMediaConversion('slider-mobile-webp')
            ->fit(Manipulations::FIT_CROP, 345, 200)
            ->format(Manipulations::FORMAT_WEBP);
        $this->addMediaConversion('slider-mobile')
            ->fit(Manipulations::FIT_CROP, 345, 200)
            ->format(Manipulations::FORMAT_JPG);
//        510x408  690x408  825x408
    }
}
