<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use App\Services\PlacesSearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use Spatie\SchemaOrg\Schema;


class MainController extends Controller
{

    public function root()
    {
        if (Session::has('locale')) {
            app()->setLocale(Session::get('locale'));
        }
        return redirect(app()->getLocale());
    }

    public function pages()
    {
        $locale = LaravelLocalization::getCurrentLocale();
        $route = Route::currentRouteName();
        $page = Page::whereTranslation("slug", $route, $locale)
            ->orWhereTranslation('slug', $route, 'ru')->first();
        $meta = [
            "title" => (isset($page)) ? $page->getMetaTitle() : null,
            "description" => (isset($page)) ? $page->getMetaDesc() : null,
        ];

        if ($route == 'contacts') {
            $schema = $this->localBusinessSchema($meta['description']);
            return view('site.contacts')->with(compact('meta', 'schema'));
        }

        if ($route == 'rules' || $route == 'terms')
            return redirect('legal-information', 301);

        if ($route == 'legal-information')
            return view('site.legal-information_' . $locale)->with(compact('meta'));

        if ($route == 'be-partner')
            return view('site.be-partner_' . $locale)->with(compact('meta'));

        if ($route == 'about')
            return view('site.about_' . $locale)->with(compact('meta'));

        if ($route == 'main') {
            $excursion_filter_places = (new PlacesSearchService('excursions'))->get();
            return view('site.homepage.index')->with(compact('meta', 'excursion_filter_places'));
        }

        return view('site.' . $route)->with(compact('meta'));
    }

    public function localBusinessSchema($description)
    {
        $url = config('app.url');
        $id = config('app.url');
        $name = config('app.name') . ' Travel';
        $email = config('mail.contact');
        //todo сделать норм. картинку
        $logo = url('static/logo_schema.png');
        $addressCountry = 'GE';
        $addressLocality = 'Батуми';
        $addressRegion = '';
        $postalCode = '220000';
        $streetAddress = 'Пр. М. Абашидзе 50';
        $telephone = '+995514511199';
        $sameAs = [
            'https://www.facebook.com/SunnyGeorgia.Travel/',
            'https://vk.com/sunnygeorgia.travel',
            'https://www.instagram.com/sunnygeorgia.travel/',
            'https://ok.ru/group/54547512623220'
        ];
        $latitude = '';
        $longitude = '';
        $dayOfWeek = [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
        ];
        $opens = '8:00:00';
        $closes = '21:00:00';
        $currenciesAccepted = \App\Currency::whereActive(true)->get()->pluck('code')->toArray();
        $image = [
            url('/images/company1x1.jpg'),
            url('/images/company4x3.jpg'),
            url('/images/company16x9.jpg')
        ];

        //todo доделать схему и $logo $image
        $localBusiness = Schema::travelAgency()
            ->setProperty('@id', $id)
            ->url($url)
            ->name($name)
            ->logo($logo)
            ->description($description)
            ->email($email)
//            ->contactPoint(Schema::contactPoint()
//                ->areaServed('Worldwide')
//
//            )
            ->telephone($telephone)
            ->address(Schema::postalAddress()
                ->addressCountry($addressCountry)
                ->addressLocality($addressLocality)
                ->addressRegion($addressRegion)
                ->postalCode($postalCode)
                ->streetAddress($streetAddress)
            )
            ->sameAs($sameAs)
//            ->aggregateRating(Schema::aggregateRating()
//
//            )
            ->geo(Schema::geoCoordinates()
                ->latitude($latitude)
                ->longitude($longitude)
            )
            ->openingHoursSpecification(Schema::openingHoursSpecification()
                ->dayOfWeek($dayOfWeek)
                ->opens($opens)
                ->closes($closes)
            )
            ->currenciesAccepted($currenciesAccepted)
            ->image($image);

        return $localBusiness;
    }

    public function changeLanguage($locale)
    {
        $locale = strtolower($locale);
        if ($locale === 'ge') $locale = 'ka';
        Session::put('locale', $locale);
        return redirect(route('main'), 301);
    }

    public function postContacts(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'message' => 'required',
        ]);

        $text = 'From: ' . $request->input('email') . ' ' . $request->input('name', 'anonim') . "\r\n";
        $text .= ' Phone: ' . $request->input('phone', 'no') . ' Contact by: ' . $request->input('contact-type', 'not set') . "\r\n";
        $text .= str_limit(strip_tags($request->input('message')), 1000);

        Mail::raw($text, function ($message) {
            $message->to(config('mail.contact'), config('mail.username'));
            $message->cc(config('mail.admin'));
            $message->subject(config('app.env') . ' Contact form message');
        });

        return back()->with(['status' => 'success', 'msg' => 'Message sent!']);
    }

    public function getRules($locale)
    {
        return view('site.rules_' . $locale);
    }

    public function getTerms($locale)
    {
        return view('site.terms_' . $locale);
    }
}
