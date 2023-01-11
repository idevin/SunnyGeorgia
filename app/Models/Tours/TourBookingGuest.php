<?php

namespace App\Models\Tours;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tours\TourBookingGuest
 *
 * @property int $id
 * @property int $tour_booking_id
 * @property string $first_name
 * @property string $last_name
 * @property bool $child
 * @property int|null $age
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereTourBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tours\TourBookingGuest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TourBookingGuest extends Model
{

}
