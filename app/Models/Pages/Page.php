<?php

namespace App\Models\Pages;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Eloquent;
use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Pages\Page
 *
 * @property int $id
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|PageTranslation[] $translations
 * @method static Builder|Page listsTranslations($translationField)
 * @method static Builder|Page newModelQuery()
 * @method static Builder|Page newQuery()
 * @method static Builder|Page notTranslatedIn($locale = null)
 * @method static Builder|Page orWhereTranslation($key, $value, $locale = null)
 * @method static Builder|Page orWhereTranslationLike($key, $value, $locale = null)
 * @method static Builder|Page orderByTranslation($key, $sortmethod = 'asc')
 * @method static Builder|Page query()
 * @method static Builder|Page translated()
 * @method static Builder|Page translatedIn($locale = null)
 * @method static Builder|Page whereCreatedAt($value)
 * @method static Builder|Page whereId($value)
 * @method static Builder|Page whereSlug($value)
 * @method static Builder|Page whereTranslation($key, $value, $locale = null)
 * @method static Builder|Page whereTranslationLike($key, $value, $locale = null)
 * @method static Builder|Page whereUpdatedAt($value)
 * @method static Builder|Page withTranslation()
 * @mixin Eloquent
 */
class Page extends Model implements TranslatableContract
{
    use Translatable;
    use CacheQueryBuilder;

    public $translatedAttributes = [
        'slug',
        'name',
        'meta_title',
        'meta_description',
    ];
    protected $table = 'pages';
    protected $guarded = [];
    public static $trans = null;

    public function getMetaTitle()
    {
        return ($this->locale_meta()->meta_title) ? $this->locale_meta()->meta_title : null;
    }

    public function locale_meta()
    {
        if (!static::$trans) {
            static::$trans = $this->translations()->where("locale", app()->getLocale())->first();
        }

        return static::$trans;
    }

    public function getMetaDesc()
    {
        return ($this->locale_meta()->meta_description) ? $this->locale_meta()->meta_description : null;
    }


}
