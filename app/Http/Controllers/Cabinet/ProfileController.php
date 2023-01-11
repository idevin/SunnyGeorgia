<?php
/**
 * Created by PhpStorm.
 * User: kirill
 * Date: 10.11.2017
 * Time: 17:25
 */

namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Controller;
use App\Partner;
use App\Services\ActivationService;
use App\Services\MobileActivationService;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view('cabinet.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
        ]);
        $user = Auth::user();
        $user->fill($request->all());

        if ($user->mobile_number != $request->input('mobile_number')) {
            $user->mobile_confirmed = false;
        }
        $user->save();

        session()->put('locale', $user->locale);
        app()->setLocale($user->locale);
        session()->put('currency', $user->currency);
        currency()->setUserCurrency($user->currency);
        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function updatePublicData(Request $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->save();
        session()->put('locale', $user->locale);
        app()->setLocale($user->locale);
        session()->put('currency', $user->currency);
        currency()->setUserCurrency($user->currency);
        return back()->with(['status' => 'success', 'msg' => 'Updated']);
    }

    public function becomePartner()
    {
        $user = Auth::user();
        if (!$user->email_verified) return redirect()->back()->with(['status' => 'error', 'success' => false, 'msg' => 'You should verify your email before']);
//        if (!$user->mobile_confirmed) return redirect()->back()->with(['status' => 'error', 'success' => false, 'msg' => 'You should verify your mobile number before']);
        if ($user->hasRole('partner')) return redirect(route('cabinet:partner:profile.view'));

        $regTypes = [
            'Физическое лицо',
            'ИП',
            'ООО',
            'ЗАО',
            'ОДО',
            'УП',
            'АОА',
        ];
        $paymentsFields = [
//            'bank_name' => 'Bank Name',
            'bank_code' => 'Bank Code',
            'bank_number' => 'Account Number',
//            'bank_iban' => 'IBAN',
//            'bank_swift' => 'SWIFT',
            'bank_recipient' => 'Beneficiary',
            'bank_address1' => 'Address 1',
            'bank_address2' => 'Address 2',
            'bank_city' => 'City',
//            'bank_country' => 'Country',
        ];

        return view('cabinet.partner_form', compact('regTypes', 'paymentsFields', 'user'));
    }

    public function postBecomePartner(Request $request)
    {
        $request->merge(['vat' => $request->input('vat') == 'on', 'bank_country' => 'Georgia']);
        $this->validate($request, [
            'agree' => 'required',
            'llc' => 'required',
            'number' => 'required',
//            'vat' => 'boolean',
//            'bank_number' => 'required',
//            'bank_name' => 'required',
        ]);
        $user = Auth::user();
        if (!$user->hasRole('partner')) {
            $user->attachRole('partner');

            if (empty($user->partner)) {
                $user->partner = new Partner();
            }
            $user->partner->fill($request->only([
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
            ]));

            $user->partner()->save($user->partner);

            return redirect(route('cabinet:partner:billing.view'))->with(['success' => 'Partner saved!']);
        }
        return redirect(route('cabinet:partner:profile.view'));
    }

    public function resendEmailLink()
    {
        //Send EMAIL verification link
        $mm = resolve(ActivationService::class);
        $mm->sendActivationMail(Auth::user());
        return back()->with(['status' => 'success', 'msg' => 'Activation link sent']);
    }

    public function resendMobileCode()
    {
        $user = Auth::user();

        if (!$user->mobile_confirmed) {
            try {
                app(MobileActivationService::class)->sendActivationMessage($user);
            } catch (\Throwable $exception) {
                return response()->json($exception->getMessage(), 400);
//            \Log::info($exception->getMessage(), ['url' => $request->path()]);
            }
            return response()->json(['msg' => 'Activation code sent']);
        } else {
            return response()->json(['status' => 'error', 'msg' => 'Mobile number already confirmed']);
        }
    }

    public function sendMobileCode(Request $request)
    {
        $this->validate($request, [
            'mobile_phone' => [
                'required',
                'regex:/^\+?([87](?!95[4-79]|99[08]|907|94[^0]|336)([348]\d|9[0-6789]|7[0247])\d{8}|[1246]\d{9,13}|68\d{7}|5[1-46-9]\d{8,12}|55[1-9]\d{9}|55[12]19\d{8}|500[56]\d{4}|5016\d{6}|5068\d{7}|502[45]\d{7}|5037\d{7}|50[4567]\d{8}|50855\d{4}|509[34]\d{7}|376\d{6}|855\d{8}|856\d{10}|85[0-4789]\d{8,10}|8[68]\d{10,11}|8[14]\d{10}|82\d{9,10}|852\d{8}|90\d{10}|96(0[79]|17[01]|13)\d{6}|96[23]\d{9}|964\d{10}|96(5[69]|89)\d{7}|96(65|77)\d{8}|92[023]\d{9}|91[1879]\d{9}|9[34]7\d{8}|959\d{7}|989\d{9}|97\d{8,12}|99[^4568]\d{7,11}|994\d{9}|9955\d{8}|996[57]\d{8}|9989\d{8}|380[3-79]\d{8}|381\d{9}|385\d{8,9}|375[234]\d{8}|372\d{7,8}|37[0-4]\d{8}|37[6-9]\d{7,11}|30[69]\d{9}|34[67]\d{8}|3[12359]\d{8,12}|36\d{9}|38[1679]\d{8}|382\d{8,9}|46719\d{10})$/'
            ]
        ]);
        $user = Auth::user();
        $phoneNumber = $request->input('mobile_phone');

        $user->mobile_number = $phoneNumber;
        $user->mobile_confirmed = false;
        $user->save();
        try {
            app(MobileActivationService::class)->sendActivationMessage($user);
        } catch (\Throwable $exception) {
            return response()->json($exception->getMessage(), 400);
//            \Log::info($exception->getMessage(), ['url' => $request->path()]);
        }

        $user->csrfToken = csrf_token();
        return response()->json(['msg' => 'Activation code sent', 'user' => $user]);
    }

    public function xhrConfirmMobileCode(Request $request)
    {
        $this->validate($request, ['code' => 'required']);
        $result = app(MobileActivationService::class)->activateUser($request->user(), $request->input('code'));
        if ($result) {
            return response()->json('success');
        } else {
            return response()->json(['success' => false], 400);
        }
    }

    public function passwordChange(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        $user = $request->user();
        if (Auth::attempt(['email' => $user->email, 'password' => $request->input('current_password')])) {
//        if (bcrypt($request->input('current_password')) === $user->password) {
            $user->password = bcrypt($request->input('password'));
            $user->save();

            return back()->with(['status' => 'success', 'msg' => 'password changed']);
        } else {
            return back()->withErrors('Wrong current password');
        }

    }
}
