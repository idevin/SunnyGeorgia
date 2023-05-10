<?php
/**
 * Created by PhpStorm.

 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Hotels;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hotels\HotelTranslation
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $locale
 * @property string $title
 * @property string $intro
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\HotelTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class HotelTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['title', 'intro', 'description'];
}