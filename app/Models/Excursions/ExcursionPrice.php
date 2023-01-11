<?php

namespace App\Models\Excursions;

use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Excursions\ExcursionPrice
 *
 * @property int $id
 * @property int $excursion_id
 * @property string $price_type
 * @property float|null $price
 * @property int|null $price_from
 * @property int|null $price_to
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Excursions\Excursion $excursion
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice whereExcursionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice wherePriceFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice wherePriceTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice wherePriceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Excursions\ExcursionPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ExcursionPrice extends Model
{
    use CacheQueryBuilder;

    protected $fillable = [
        'excursion_id',
        'price_type',
        'price',
        'price_from',
        'price_to'
    ];

    public function excursion()
    {
        return $this->belongsTo(Excursion::class);
    }
}
