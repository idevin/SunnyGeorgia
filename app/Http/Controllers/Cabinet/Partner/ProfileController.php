<?php

namespace App\Http\Controllers\Cabinet\Partner;

use App\Http\Controllers\Controller;
use App\Partner;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function view()
    {
        $user = Auth::user();
        $partner = $user->partner;
        if (empty($partner)) {
            $partner = new Partner();
            $partner->first_name = $user->first_name;
            $partner->last_name = $user->last_name;
            $partner->email = $user->email;
        }

        $regTypes = [
            'Физическое лицо',
            'ИП',
            'ООО',
            'ЗАО',
            'ОДО',
            'УП',
            'АОА',
        ];

        return view('cabinet.partner.profile', compact('user', 'partner', 'regTypes'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
//            'first_name' => 'required',
            'llc' => 'required',
            'number' => 'required',
        ]);


        //echo $ms; dd($messengers_arr);


        $user = Auth::user();
        $partner = $user->partner;


        if (empty($partner)) {
            $partner = new Partner();
        }

        if (!$partner->verified) {
            $request->merge(['vat' => $request->input('vat') == 'on']);


            //   MESSENGERS BLOCK

            $messengers_input = $request->input('messengers_arr');
            $messengers_arr = (isset($messengers_input["check"])) ? [] : null;

            if (isset($messengers_input["check"])) {
                foreach ($messengers_input["check"] as $key) {
                    $messengers_arr[$key] = $messengers_input["val"][$key];
                }
            }

            $request->merge(['messengers' => ($messengers_arr) ? json_encode($messengers_arr) : null]);

            //     END       MESSENGERS BLOCK

            $partner->fill($request->only([
                'logo_image_id',
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
                'website',
                'created_at',
                'updated_at',
                'first_name',
                'last_name',
                'birthday',
                'postcode',
                'messengers',
                'bank_name',
                'bank_number'
            ]));
            $user->partner()->save($partner);

            return back()
                ->with(['status' => 'success', 'msg' => 'Profile saved']);

        } else {
            return back()
                ->withErrors('You can\'t change your partner profile after verifying!');
        }
    }

    /**
     * @todo Сделать страницу и пагинацию билинга, обновление базы
     */
    public function viewBilling()
    {
        $fields = [
//            'bank_name' => 'Bank Name',
//            'bank_code' => 'Bank Code',
//            'bank_number' => 'Account Number',
//            'bank_iban' => 'IBAN',
//            'bank_swift' => 'SWIFT',
//            'bank_recipient' => 'Beneficiary',
            'bank_address1' => 'Address 1',
            'bank_address2' => 'Address 2',
            'bank_city' => 'City',
//            'bank_country' => 'Country',
        ];
        $user = Auth::user();
        $partner = $user->partner;
        if (empty($partner)) {
            $partner = new Partner();
        }

        return view('cabinet.partner.billing', compact('fields', 'user', 'partner'));
    }


    public function updateBilling(Request $request)
    {
        $request->merge(['vat' => $request->input('vat') == 'on']);
        $request->merge(['bank_country' => 'Georgia']);
        $this->validate($request, [
            'bank_number' => 'required',
            'bank_name' => 'required',
        ]);
        $user = Auth::user();
        if (empty($user->partner)) {
            $user->partner = new Partner();
        }
        $user->partner->fill($request->only(
            [
                'bank_name',
                'bank_code',
                'bank_number',
//                'bank_iban',
//                'bank_swift',
                'bank_recipient',
                'bank_city',
                'bank_country',
                'bank_address1',
                'bank_address2'
            ]
        ));
        $user->partner()->save($user->partner);


        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }
}
