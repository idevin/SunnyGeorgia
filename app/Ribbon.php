<?php

namespace App;


use App\Models\Excursions\Excursion;
use App\Models\Tours\Tour;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Ribbon
 *
 * @property int $id
 * @property string|null $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Excursions\Excursion[] $excursions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tours\Tour[] $tours
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\RibbonTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Ribbon withTranslation()
 * @mixin \Eloquent
 */
class Ribbon extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['title'];
    protected $fillable = ['type'];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function excursions()
    {
        return $this->hasMany(Excursion::class);
    }

}
