<?php
/**
 * Created by PhpStorm.

 * Date: 09.11.2017
 * Time: 15:08
 */

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tours\AccommodationTranslation
 *
 * @property int $id
 * @property int $accommodation_id
 * @property string $locale
 * @property string|null $hotel
 * @property string|null $room
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation whereAccommodationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation whereHotel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\AccommodationTranslation whereRoom($value)
 * @mixin \Eloquent
 */
class AccommodationTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['hotel', 'room'];
}