<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PlaceTranslation
 *
 * @property int $id
 * @property int $place_id
 * @property string $locale
 * @property string|null $name
 * @property string|null $meta_keywords
 * @property string|null $page
 * @property mixed $meta_title
 * @property mixed $meta_description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlaceTranslation wherePlaceId($value)
 * @mixin \Eloquent
 */
class PlaceTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['slug', 'name', 'page', 'meta_title', 'meta_description'];
}
