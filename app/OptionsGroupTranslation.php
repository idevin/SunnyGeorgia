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
 * App\OptionsGroupTranslation
 *
 * @property int $id
 * @property int $options_group_id
 * @property string $locale
 * @property string|null $title
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation whereOptionsGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionsGroupTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class OptionsGroupTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
}