<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\OptionTranslation
 *
 * @property int $id
 * @property int $option_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\OptionTranslation whereTitle($value)
 * @mixin \Eloquent
 */
class OptionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
}