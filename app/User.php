<?php

namespace App;

use App\Models\Excursions\Excursion;
use App\Models\Excursions\ExcursionBooking;
use App\Models\Hotels\Hotel;
use App\Models\Hotels\HotelBooking;
use App\Models\Tours\Tour;
use App\Models\Tours\TourBooking;
use App\Notifications\MailResetPasswordToken;
use App\Repositories\MobileActivationRepository;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * App\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $display_name
 * @property string $email
 * @property bool $email_verified
 * @property string $password
 * @property string|null $mobile_number
 * @property bool $mobile_confirmed
 * @property Carbon|null $birthday
 * @property int|null $avatar_id
 * @property string|null $social_link
 * @property string|null $description
 * @property string|null $country
 * @property string|null $id_number
 * @property string|null $p_address
 * @property string|null $p_city
 * @property string|null $p_country
 * @property string|null $p_postcode
 * @property string $locale
 * @property string $currency
 * @property string|null $remember_token
 * @property string|null $last_visit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $trusted
 * @property-read Media|null $avatar
 * @property-read Collection|ExcursionBooking[] $excursionBookings
 * @property-read Collection|Excursion[] $excursions
 * @property-read Collection|HotelBooking[] $hotelBookings
 * @property-read Collection|Hotel[] $hotels
 * @property-read Collection|Media[] $images
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read Partner $partner
 * @property-read Collection|ExcursionBooking[] $partnerExcursionsBookings
 * @property-read Collection|TourBooking[] $partnerTourBookings
 * @property-read Collection|BankPayment[] $payments
 * @property-read Collection|Permission[] $permissions
 * @property-read Collection|Role[] $roles
 * @property-read Collection|TourBooking[] $tourBookings
 * @property-read Collection|Tour[] $tours
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAvatarId($value)
 * @method static Builder|User whereBirthday($value)
 * @method static Builder|User whereCountry($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCurrency($value)
 * @method static Builder|User whereDescription($value)
 * @method static Builder|User whereDisplayName($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerified($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIdNumber($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereLastVisit($value)
 * @method static Builder|User whereLocale($value)
 * @method static Builder|User whereMobileConfirmed($value)
 * @method static Builder|User whereMobileNumber($value)
 * @method static Builder|User wherePAddress($value)
 * @method static Builder|User wherePCity($value)
 * @method static Builder|User wherePCountry($value)
 * @method static Builder|User wherePPostcode($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePermissionIs($permission = '')
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereRoleIs($role = '')
 * @method static Builder|User whereSocialLink($value)
 * @method static Builder|User whereTrusted($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereSysEmails($value)
 * @mixin Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, LaratrustUserTrait; // add this trait to your user model

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'email',
        'first_name',
        'last_name',
        'email_verified',
        'mobile_number',
        'mobile_confirmed',
        'birthday',
        'social_link',
        'id_number',
        'description',
        'country',
        'last_visit',
        'created_at',
        'password',
        'p_address',
        'p_city',
        'p_country',
        'p_postcode',
        'locale',
        'currency',
        'sys_emails'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'birthday'
    ];

    public function routeNotificationForSmscru()
    {
        // Country code, area code and number without symbols or spaces
        return preg_replace('/\D+/', '', $this->mobile_number);
    }

    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    public function mobileVerificationCodes()
    {
        return (new MobileActivationRepository)->getActivation($this);
    }

    public function images()
    {
        return $this->hasMany(Media::class);
    }

    public function partner()
    {
        return $this->hasOne(Partner::class);
    }

    public function hotelBookings()
    {
        return $this->hasMany(HotelBooking::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function excursions()
    {
        return $this->hasMany(Excursion::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function partnerTourBookings()
    {
        return $this->hasManyThrough(TourBooking::class, Tour::class);
    }

    public function partnerExcursionsBookings()
    {
        return $this->hasManyThrough(ExcursionBooking::class, Excursion::class);
    }

    public function tourBookings()
    {
        return $this->hasMany(TourBooking::class, 'customer_id');
    }

    public function excursionBookings()
    {
        return $this->hasMany(ExcursionBooking::class, 'customer_id');
    }

    public function avatar()
    {
        return $this->belongsTo(Media::class, 'avatar_id');
    }

    public function payments()
    {
        return $this->hasMany(BankPayment::class);
    }
}
