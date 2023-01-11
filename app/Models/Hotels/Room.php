<?php

namespace App\Models\Hotels;


use App\Media;
use App\Option;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hotels\Room
 *
 * @property int $id
 * @property int $hotel_id
 * @property int $amount
 * @property float|null $area
 * @property int|null $thumb_id
 * @property float $price
 * @property bool $published
 * @property string $title
 * @property int $adults
 * @property int $kids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Hotels\RoomsAvailability[] $availability
 * @property-read \App\Models\Hotels\Hotel $hotel
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $images
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Option[] $options
 * @property-read \App\Media|null $thumb
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereAdults($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereHotelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereKids($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereThumbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\Room whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Room extends Model
{
    public function images()
    {
        return $this->belongsToMany(Media::class);
    }

    public function availability()
    {
        return $this->hasMany(RoomsAvailability::class);
    }

    public function thumb()
    {
        return $this->belongsTo(Media::class, 'thumb_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function available(Carbon $dateFrom, Carbon $dateTo)
    {
        return $this->hasMany(RoomsAvailability::class)->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()]);
    }

    public function options()
    {
        return $this->morphToMany(Option::class, 'optionable')
            ->withPivot('value', 'price', 'free');
    }

}
