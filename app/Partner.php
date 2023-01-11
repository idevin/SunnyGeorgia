<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Partner
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $logo_image_id
 * @property string|null $description
 * @property bool $vat
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $birthday
 * @property string|null $llc
 * @property string $reg_type
 * @property string|null $name
 * @property string|null $number
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $fax
 * @property string|null $country
 * @property string|null $city
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $postcode
 * @property bool $address_confirmed
 * @property string|null $bank_name
 * @property string|null $bank_code
 * @property string|null $bank_number
 * @property string|null $bank_iban
 * @property string|null $bank_swift
 * @property string|null $bank_city
 * @property string|null $bank_country
 * @property string|null $bank_address1
 * @property string|null $bank_address2
 * @property string|null $bank_recipient
 * @property string|null $website
 * @property int|null $legal_status_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $verified
 * @property mixed|null $messengers
 * @property-read \App\Media|null $logo
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereAddressConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankRecipient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBankSwift($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLegalStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLlc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereLogoImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereMessengers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereRegType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Partner whereWebsite($value)
 * @mixin \Eloquent
 */
class Partner extends Model
{

    public $fillable = [
        'description',
        'first_name',
        'last_name',
        'birthday',
        'vat',
        'llc',
        'reg_type',
        'name',
        'number',
        'phone',
        'fax',
        'email',
        'country',
        'city',
        'address1',
        'address2',
        'postcode',
        'address_confirmed',
        'bank_name',
        'bank_code',
        'bank_number',
        'bank_iban',
        'bank_recipient',
        'bank_swift',
        'bank_city',
        'bank_country',
        'bank_address1',
        'bank_address2',
        'website',
        'legal_status_id',
        'messengers'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logo()
    {
        return $this->belongsTo(Media::class, 'logo_image_id');
    }

    public function messengers_arr()
    {
        if ($this->messengers) return json_decode($this->messengers);
        return null;
    }
}
