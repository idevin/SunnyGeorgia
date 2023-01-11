<?php

namespace App;


use Geeky\Database\CacheQueryBuilder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Media
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $path
 * @property int|null $model_id
 * @property string|null $model_type
 * @property string|null $path_high
 * @property string|null $url_high
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media wherePathHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUrlHigh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Media whereUserId($value)
 * @mixin \Eloquent
 */
class Media extends Model
{
    use CacheQueryBuilder;

    public $timestamps = true;
    public $exists = true;
    protected $fillable = ['url'];
    protected $table = 'media';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
