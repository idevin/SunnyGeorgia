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

namespace App\Traits;

use App\GeneratedReview;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasGeneratedReviews
{
    public function createGeneratedReview($data): bool
    {
        return $this->getGeneratedReviewModel()->createReview($this, $data);
    }

    protected function getGeneratedReviewModel(): Model
    {
        $model = GeneratedReview::class;

        return new $model();
    }

    public function updateGeneratedReview($id, $data): bool
    {
        return $this->getGeneratedReviewModel()->updateReview($id, $data);
    }

    public function deleteGeneratedReview($id): bool
    {
        return $this->getGeneratedReviewModel()->deleteReview($id);
    }

    public function getGeneratedRating(): float
    {
        return round($this->generatedReviews()->avg('rating'));
    }

    public function generatedReviews(): MorphMany
    {
        return $this->morphMany(GeneratedReview::class, 'reviewable');
    }
}
