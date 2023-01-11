<?php

namespace App;

use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Currency
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property string $format
 * @property string $exchange_rate
 * @property bool $active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $acceptable
 * @method static Builder|Currency newModelQuery()
 * @method static Builder|Currency newQuery()
 * @method static Builder|Currency query()
 * @method static Builder|Currency whereAcceptable($value)
 * @method static Builder|Currency whereActive($value)
 * @method static Builder|Currency whereCode($value)
 * @method static Builder|Currency whereCreatedAt($value)
 * @method static Builder|Currency whereExchangeRate($value)
 * @method static Builder|Currency whereFormat($value)
 * @method static Builder|Currency whereId($value)
 * @method static Builder|Currency whereName($value)
 * @method static Builder|Currency whereSymbol($value)
 * @method static Builder|Currency whereUpdatedAt($value)
 */
class Currency extends Model
{
    use CacheQueryBuilder;

    protected $fillable = [
        'code', 'exchange_rate', 'active', 'acceptable', 'format', 'symbol', 'name'
    ];
}
