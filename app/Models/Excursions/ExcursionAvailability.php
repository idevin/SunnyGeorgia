<?php

namespace App\Models\Excursions;


use Eloquent;
use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Excursions\ExcursionAvailability
 *
 * @property int $id
 * @property int $excursion_id
 * @property string $date
 * @property string $time
 * @property int $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Excursion $excursion
 * @method static Builder|ExcursionAvailability newModelQuery()
 * @method static Builder|ExcursionAvailability newQuery()
 * @method static Builder|ExcursionAvailability query()
 * @method static Builder|ExcursionAvailability whereAmount($value)
 * @method static Builder|ExcursionAvailability whereCreatedAt($value)
 * @method static Builder|ExcursionAvailability whereDate($value)
 * @method static Builder|ExcursionAvailability whereExcursionId($value)
 * @method static Builder|ExcursionAvailability whereId($value)
 * @method static Builder|ExcursionAvailability whereTime($value)
 * @method static Builder|ExcursionAvailability whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ExcursionAvailability extends Model
{

    use CacheQueryBuilder;

    protected $fillable = [
        'excursion_id',
        'date',
        'time',
        'amount',
    ];

    public function excursion()
    {
        return $this->belongsTo(Excursion::class);
    }

    public function bookCreated()
    {
        return $this->hasMany(ExcursionBooking::class)
            ->where('status', 'created')
            ->selectRaw('sum(qty_kids + qty_adults) as total_reserved')
            ->first()
            ->total_reserved;
    }

    public function bookPayed()
    {
        return $this->hasMany(ExcursionBooking::class)
            ->where('status', 'payed')
            ->selectRaw('sum(qty_kids + qty_adults) as total_reserved')
            ->first()
            ->total_reserved;
    }
}
