<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * App\RibbonTranslation
 *
 * @property int $id
 * @property int $ribbon_id
 * @property string $locale
 * @property string $title
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation whereRibbonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RibbonTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RibbonTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];
}
