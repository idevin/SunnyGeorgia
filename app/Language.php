<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Language
 *
 * @property int $id
 * @property string $locale
 * @property string $name
 * @property int|null $order
 * @property string|null $iso_name
 * @property string|null $iso_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereIsoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereIsoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Language whereOrder($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
    public $timestamps = false;

}