<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pages\PageTranslation
 *
 * @property int $id
 * @property int $page_id
 * @property string $locale
 * @property string|null $name
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property-read \App\Models\Pages\Page $page
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Pages\PageTranslation wherePageId($value)
 * @mixin \Eloquent
 */
class PageTranslation extends Model
{
    public $timestamps = false;
    protected $table = 'page_translations';
    protected $fillable = [
        'page_id',
        'locale',
        'name',
        'meta_title',
        'meta_description',
        'slug'
    ];
}

