<?php

namespace App\Models\Tours;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Hotels\AccommodationsAvailability
 *
 * @property-read \App\Models\Hotels\Room $accommodation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\AccommodationsAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\AccommodationsAvailability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Hotels\AccommodationsAvailability query()
 * @mixin \Eloquent
 */
class AccommodationsAvailability extends Model
{
    public function accommodation()
    {
        return $this->belongsTo(Room::class);
    }
}
