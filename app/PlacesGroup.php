<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\PlacesGroup
 *
 * @property int $id
 * @property string|null $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Place[] $places
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PlacesGroupTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroup withTranslation()
 * @mixin \Eloquent
 */
class PlacesGroup extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['code'];


    public function places()
    {
        return $this->hasMany(Place::class);
    }

}