<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App;

use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Place
 *
 * @property int $id
 * @property int|null $places_group_id
 * @property string|null $slug
 * @property string|null $weather_code
 * @property bool $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property float|null $lat
 * @property float|null $long
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Excursions\Excursion[] $excursions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotels\Hotel[] $hotels
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $images
 * @property-read \App\PlacesGroup|null $placesGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\Tour[] $tours
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PlaceTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|Place listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Place notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Place orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Place orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Place orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Place query()
 * @method static \Illuminate\Database\Eloquent\Builder|Place translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Place translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereLong($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place wherePlacesGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place whereWeatherCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Place withTranslation()
 * @mixin \Eloquent
 */
class Place extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['slug', 'name', 'page', 'meta_title', 'meta_description'];
    protected $fillable = ['lat', 'long', 'places_group_id'];

    public function placesGroup()
    {
        return $this->belongsTo(PlacesGroup::class);
    }

    public function excursions()
    {
        return $this->belongsToMany(Excursion::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class, 'start_place_id');
    }

    public function images()
    {
        return $this->belongsToMany(Media::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
