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
 * App\OptionsGroup
 *
 * @property int $id
 * @property bool $main_list
 * @property bool $tours
 * @property bool $excursions
 * @property bool $hotels
 * @property bool $rooms
 * @property bool $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $optionsCollection
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OptionsGroupTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereExcursions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereHotels($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereMainList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereRooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereTours($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroup withTranslation()
 * @mixin \Eloquent
 */
class OptionsGroup extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    /**
     * @deprecated
     */
    public function optionsCollection()
    {
        return $this->hasMany(Option::class, 'options_group_id');
    }


    /**
     * BUGFIX with model to JSON
     * @package dimsav/laravel-translatable
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        if (!$this->relationLoaded('translations') && !$this->toArrayAlwaysLoadsTranslations()) {
            return $attributes;
        }

        $hiddenAttributes = $this->getHidden();

        foreach ($this->translatedAttributes as $field) {
            if (in_array($field, $hiddenAttributes)) {
                continue;
            }

            if ($translations = $this->getTranslation()) {
//                $attributes[$field] = $translations->$field;
                $attributes[$field] = $this->$field;

            }
        }

        return $attributes;
    }
}