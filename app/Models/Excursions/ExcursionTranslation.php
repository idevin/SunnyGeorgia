<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Excursions;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Excursions\ExcursionTranslation
 *
 * @property int $id
 * @property int $excursion_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $intro
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereExcursionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class ExcursionTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'slug',
        'title',
        'intro',
        'description',
        'meta_title',
        'meta_description',
        'start_place',
    ];
}
