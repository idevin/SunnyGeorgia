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
 * App\PlacesGroupTranslation
 *
 * @property int $id
 * @property int $places_group_id
 * @property string $locale
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PlacesGroupTranslation wherePlacesGroupId($value)
 * @mixin \Eloquent
 */
class PlacesGroupTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['name'];
}