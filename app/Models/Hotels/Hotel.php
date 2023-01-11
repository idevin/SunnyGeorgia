<?php

namespace App\Models\Hotels;


use App\Media;
use App\Option;
use App\Place;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

/**
 * App\Models\Hotels\Hotel
 *
 * @property int $id
 * @property int $user_id
 * @property int $place_id
 * @property int|null $thumb_id
 * @property float|null $price
 * @property bool $published
 * @property string|null $type
 * @property string|null $address
 * @property string|null $in_time
 * @property string|null $out_time
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $email
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $reviewed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotels\HotelBooking[] $bookings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read \App\Place $place
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotels\Room[] $rooms
 * @property-read \App\Media|null $thumb
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotels\HotelTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereInTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereOutTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereThumbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Hotel withTranslation()
 * @mixin \Eloquent
 */
class Hotel extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title', 'intro', 'description'];

    public function images()
    {
        return $this->belongsToMany(Media::class);
    }

    public function thumb()
    {
        return $this->belongsTo(Media::class, 'thumb_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function options()
    {
        return $this->morphToMany(Option::class, 'optionable')
            ->withPivot('value', 'price', 'free');
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
