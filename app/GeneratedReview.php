<?php
declare(strict_types=1);
/*
 * This file is part of Laravel Reviewable.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class GeneratedReview extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function createReview(Model $reviewable, $data): bool
    {
        $review = new static();
        $review->fill($data);
        return (bool)$reviewable->reviews()->save($review);
    }

    public function updateReview($id, $data): bool
    {
        return (bool)static::find($id)->update($data);
    }

    public function deleteReview($id): bool
    {
        return (bool)static::find($id)->delete();
    }
}
