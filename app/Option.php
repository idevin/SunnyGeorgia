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
use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Option
 *
 * @property int $id
 * @property int $options_group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\OptionsGroup $group
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $optionable
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\OptionTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereOptionsGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option withTranslation()
 * @mixin \Eloquent
 */
class Option extends Model implements TranslatableContract
{
    use Translatable;

    use CacheQueryBuilder;

    public $translatedAttributes = ['title', 'description'];

    public function group()
    {
        return $this->belongsTo(OptionsGroup::class, 'group_id');
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

    public function optionable()
    {
        return $this->morphTo();
    }
}
