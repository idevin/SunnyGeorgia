<?php

namespace App\Models\Tours;


use App\Currency;
use App\Option;
use App\Partner;
use App\Place;
use App\Ribbon;
use App\Traits\HasGeneratedReviews;
use App\User;
use Artisanry\Reviewable\Traits\HasReviews;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Astrotomic\Translatable\Translatable;
use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Tours\Tour
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $start_place_id
 * @property int|null $thumb_id
 * @property float|null $price
 * @property bool $price_per_person
 * @property bool $published
 * @property bool $calendar_use
 * @property bool $flight_included
 * @property float|null $flight_price
 * @property bool $transfer_included
 * @property float|null $transfer_price
 * @property int $min_people
 * @property int|null $max_people
 * @property int|null $free_cancel_before
 * @property int $days
 * @property int $nights
 * @property int|null $adults
 * @property int|null $children
 * @property string|null $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property bool $reviewed
 * @property int $score
 * @property string|null $currency_code
 * @property int|null $currency_id
 * @property bool $noindex_ru
 * @property bool $noindex_ge
 * @property bool $noindex_en
 * @property int $commission
 * @property int|null $commission_proposal
 * @property-read Collection|Accommodation[] $accommodations
 * @property-read Collection|AccommodationAvailability[] $availability
 * @property-read Currency|null $currency
 * @property-read Currency $flightCur
 * @property-read Collection|Option[] $foodOptions
 * @property-read mixed $min_price
 * @property-read Collection|\App\Media[] $images
 * @property Collection|Option[] $options
 * @property-read Partner $partner
 * @property-read Place|null $place
 * @property-read Collection|Place[] $places
 * @property-read Collection|Review[] $reviews
 * @property-read Collection|Ribbon[] $ribbons
 * @property-read \App\Media|null $thumb
 * @property-read Currency $transferCur
 * @property-read Collection|TourTranslation[] $translations
 * @property-read User $user
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour notTranslatedIn($locale = null)
 * @method static Builder|Tour onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Tour query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Tour translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCalendarUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereChildren($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCommissionProposal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereFlightIncluded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereFlightPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereFreeCancelBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereMaxPeople($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereMinPeople($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereNights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereNoindexEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereNoindexGe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereNoindexRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour wherePricePerPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereStartPlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereThumbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTransferIncluded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTransferPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tour withTranslation()
 * @method static Builder|Tour withTrashed()
 * @method static Builder|Tour withoutTrashed()
 * @mixin Eloquent
 */
class Tour extends Model implements HasMedia, TranslatableContract
{
    use Translatable, SoftDeletes, HasReviews, HasGeneratedReviews, InteractsWithMedia;

    use CacheQueryBuilder;

    public $translatedAttributes = ['slug', 'title', 'intro', 'description', 'meta_title', 'meta_description'];
    protected $fillable = [
        'free_cancel_before',
        'transfer_included',
        'transfer_price',
        'currency_id',
        'currency_code',
        'start_place_id',
        'min_people',
        'max_people',
        'days',
        'nights',
        'adults',
        'children',
        'published',
        'score',
        'noindex_ru',
        'noindex_en',
        'noindex_ge',
        'commission',
        'commission_proposal',
        'prepay',
        'food_option_id'
    ];

    protected $hidden = ['commission_proposal'];

    protected $appends = [
        'new_thumb',
        'average_rating'
    ];

    public function getNewThumbAttribute()
    {
        $mainImage = $this->getMedia('tours')->first();
        if ($mainImage) {
            return [
                'jpg' => $mainImage->getUrl('thumb'),
                'webp' => $mainImage->getUrl('thumb-webp'),
                'alt' => $mainImage->getCustomProperty('alt', $this->title)
            ];
        }
        return [
            'jpg' => '/static/images/assets/cards/card1.jpg',
            'webp' => '/static/images/assets/cards/card1.jpg',
            'alt' => $this->title
        ];
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class)->orderBy('price_adult', 'asc');
    }

    public function availability()
    {
        return $this->hasManyThrough(AccommodationAvailability::class, Accommodation::class);
    }

    public function options()
    {
        return $this->morphToMany(Option::class, 'optionable')
            ->withPivot('value', 'price', 'free');
    }

    public function place()
    {
        return $this->belongsTo(Place::class, 'start_place_id');
    }

    public function places()
    {
        return $this->belongsToMany(Place::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function foodOption()
    {
        return $this->belongsTo(TourFoodOption::class);
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

    public function priceOptions()
    {
        return $this->hasMany(TourPriceOption::class);
    }

    public function types()
    {
        return $this->belongsToMany(TourType::class, 'tour_tour_type');
    }

    public function parts()
    {
        return $this->hasMany(TourDay::class)->orderBy('day_order');
    }

    public function getMinPriceAttribute()
    {
        return $this->getMinPrice();
    }

    public function getMinPrice()
    {
        $minPrice = null;
        if ($this->accommodations) {
            foreach ($this->accommodations as $acm) {
                $pr = $acm->price_adult;
                if ($pr < $minPrice || is_null($minPrice)) {
                    $minPrice = $pr;
                }
            }
        }
        return (int)$minPrice;
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
            ->useDisk('tours');
    }

    /**
     * @param Media|null $media
     * @throws InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb-webp')
            ->fit(Manipulations::FIT_CROP, 230, 230)
//            ->sharpen(10)
            ->format(Manipulations::FORMAT_WEBP);
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CROP, 230, 230)
//            ->sharpen(10)
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
