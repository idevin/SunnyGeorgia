<?php

use App\Media;
use App\Partner;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'email' => 'super@sunnygeorgia.travel',
            'first_name' => 'auto',
            'last_name' => 'auto',
            'password' => bcrypt(str_random(30))
        ]);
        $user->attachRoles(['user', 'partner', 'admin']);

        //Load users from previous db
        $users = \AppOld\OldUser::all();

        foreach ($users as $oldUser) {
            $this->transfer($oldUser);
        }

        $me = User::where('email', 'nitogel@gmail.com')->first();
        $me->syncRoles(['user', 'partner', 'admin']);


    }

    public function transfer(\AppOld\OldUser $oldUser)
    {
        $oldUser = $oldUser->toArray();
        foreach ($oldUser as $field => $item) {
            $oldUser[$field] = preg_replace('/[\x00-\x1F\x7F]/u', '', $item);
            $oldUser[$field] = trim($item);
        }
//        dump($oldUser);
        $newUser = [
            'email' => $oldUser['email'] ? strtolower($oldUser['email']) : str_random(15) . '@random_mail.com',
            'first_name' => $oldUser['user_name'],
            'last_name' => $oldUser['user_lastname'],
            'display_name' => $oldUser['nick_name'] ? $oldUser['nick_name'] : null,
            'email_verified' => $oldUser['active'] ? true : false,
            'mobile_number' => $oldUser['phone'] ? str_replace('+', '', $oldUser['phone']) : null,
            'mobile_confirmed' => $oldUser['phone_confirm'] ? true : false,
            'birthday' => $oldUser['birth_date'] && ($oldUser['birth_date'] != '0000-00-00') ? Carbon::parse($oldUser['birth_date']) : null,
            'social_link' => $oldUser['soc_identity'] ? $oldUser['soc_identity'] : null,
            'id_number' => $oldUser['id_number'] ? $oldUser['id_number'] : null,
            'description' => !$oldUser['is_company'] && $oldUser['description'] ? $oldUser['description'] : null,
            'country' => $oldUser['country'],
            'last_visit' => $oldUser['last_visit'] ? Carbon::createFromTimestamp($oldUser['last_visit']) : null,
            'created_at' => $oldUser['reg_date'] && ($oldUser['reg_date'] != '0000-00-00 00:00:00') ? Carbon::parse($oldUser['reg_date']) : Carbon::now(),
            'password' => $oldUser['user_password'] ? bcrypt($oldUser['user_password']) : bcrypt(str_random(30)),
        ];
        dump($newUser['email']);
        $user = User::create($newUser);
        $user->attachRole('user');

        $user->avatar_id = $this->saveAvatar($user, $oldUser['avatar_path']);
        $user->save();

        if ($oldUser['is_company'] || (!empty($oldUser['address']))) {

            $user->attachRole('partner');

            $newPartner = [
                'user_id' => $user->id,
                'logo_image_id' => null,

                'description' => $oldUser['description'] ? $oldUser['description'] : null,

                'vat' => $oldUser['vat_status'] ? true : false,
                'first_name' => $oldUser['user_name'],
                'last_name' => $oldUser['user_lastname'],
                'birthday' => $oldUser['birth_date'] && ($oldUser['birth_date'] != '0000-00-00') ? Carbon::parse($oldUser['birth_date']) : null,

                'llc' => $oldUser['llc_name'] ? $oldUser['llc_name'] : null,
                'name' => $oldUser['company_title'],
                'number' => $oldUser['registration_number'],
                'phone' => str_replace('+', '', $oldUser['phone']),
                'fax' => $oldUser['fax_number'],
                'country' => $oldUser['country'],
                'city' => $oldUser['town'],
                'address1' => $oldUser['address'],
                'address2' => null,
                'postcode' => $oldUser['zip'],
                'address_confirmed' => $oldUser['payment_address_status'] ? true : false,

                'bank_name' => $oldUser['company_bank_name'],
                'bank_code' => $oldUser['company_bank_code'],
                'bank_number' => $oldUser['company_bank_number'],
                'bank_iban' => $oldUser['iban'],
                'bank_swift' => $oldUser['swift'],
                'bank_city' => $oldUser['company_bank_city'],
                'bank_country' => $oldUser['company_bank_country'],//code?!?
                'bank_address1' => $oldUser['company_bank_address'],
                'bank_address2' => null,
                'bank_recipient' => $oldUser['company_bank_payment_recipient'],
                'website' => $oldUser['website'] ? $oldUser['website'] : null,
                'legal_status_id' => $oldUser['legal_status_id'] ? (integer)$oldUser['legal_status_id'] : null,
                'created_at' => $oldUser['reg_date'] && ($oldUser['reg_date'] != '0000-00-00 00:00:00') ? Carbon::parse($oldUser['reg_date']) : Carbon::now(),
//            'updated_at' => '',
            ];

            Partner::create($newPartner);
        }

    }

    private function sample()
    {
        $sample = [
//            "id" => 2263,
//            "social_id" => "", not used
//            "social_source" => "", not used
//            "balance" => 0.0, not used
//            "point_balance" => 0.0, not used
            "user_name" => "",
            "user_lastname" => "",
//            "nick_name" => "", not used
            "email" => "info@galavniskari.ge",
//            "user_password" => "a238231b1c8a4b18a4cea0aeed524e21",
//            "company" => "", not used
//            "position" => "", not used
            "id_number" => "", //??
            "description" => "", //??
            "phone" => "",
//            "phone_code" => "",//not used
//            "additional_phone" => "", //not used
            "country" => "",
            "town" => "",
            "address" => "",
            "website" => "",
            "last_visit" => 0,
//            "passchange_key" => "",
//            "activation_key" => "b411363525d6d9559b166f0141ba3ab6",
            "active" => 0,
            "reg_date" => "2017-12-09 14:38:24",
//            "company_title" => "",//not used
//            "company_brand_name" => "" //not used,
//            "company_country" => 0,//not used
//            "company_town" => "",//not used
//            "company_address" => "",
//            "company_phone" => "",
//            "company_email" => "",
//            "company_id_number" => "",
            "company_bank_name" => "",
            "company_bank_code" => "",
            "company_bank_number" => "",
            "company_bank_country" => 0,
            "company_bank_address" => "",
//            "company_facebook" => "",//not used
//            "company_website" => "",//not used
//            "company_working_hours" => "",//not used
//            "company_logo" => "", //not used
//            "map_pos" => "", not used
//            "company_warehouses" => "",//not used
//            "company_information_approved" => 0,//not used
            "is_company" => 1,
//            "votes_count" => 0, not used
//            "vote_rating" => 0, not used
            "finally_deleted" => 0,
//            "contract_from" => "0000-00-00", not used
//            "contract_till" => "0000-00-00", not used
//            "documents_status" => null, not used
            "iban" => null,
            "swift" => null,
            "company_bank_city" => null,
            "company_bank_payment_recipient" => "",
            "vat_status" => null,
            "birth_date" => null,
            "fax_number" => null,
            "zip" => "",
            "payment_address_status" => 0,
            "registration_number" => "",
            "avatar_path" => null,
            "legal_status_id" => null,
            "soc_identity" => "",
            "phone_confirm" => null,
            "payment_status" => null,
            "requisites_status" => null,
//            "confirm_phone_code" => null,
            "llc_name" => "",
        ];
    }

    public function saveAvatar(User $user, $userAvatarFileName)
    {
        $image = null;
        if (empty($userAvatarFileName)) return null;

//        $url = 'https://sunnygeorgia.travel/uploads/avatars/' . $userAvatarFileName;
        $url = 'https://s3.eu-central-1.amazonaws.com/sunny-geo-old/avatar/' . strtolower($userAvatarFileName);

        try {
            $contents = file_get_contents($url);

            $image = ImageLib::make($contents);
            $imageNormal = $image->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageNormal = $imageNormal->stream();

            $name = substr($url, strrpos($url, '/') + 1);
            $name = strtolower($name);
            $path = 'original/' . $user->id . '/' . $name;
            $t = Storage::cloud()->put($path, $imageNormal->__toString(), 'public');
            $imageNamePath = Storage::cloud()->url($path);
            if ($t) {
                $image = new Media();
                $image->name = $name;
                $image->url = $imageNamePath;
                $image->user_id = $user->id;
                $image->save();

            }
        } catch (Exception $e) {
            dump($e->getMessage());
        }
        if ($image) {
            return $image->id;
        } else {
            return null;
        }
    }
}
