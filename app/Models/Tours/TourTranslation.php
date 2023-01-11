<?php

namespace App\Models\Tours;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tours\TourTranslation
 *
 * @property int $id
 * @property int $tour_id
 * @property string $locale
 * @property string|null $title
 * @property string|null $intro
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereIntro($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TourTranslation whereTourId($value)
 * @mixin \Eloquent
 */
class TourTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = ['slug', 'title', 'intro', 'description', 'meta_title', 'meta_description'];
}
