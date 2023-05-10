<?php

namespace App\Http\Controllers\Cabinet\Partner;

use App\Http\Controllers\Controller;
use App\Partner;
use Auth;
use Request;

class HotelsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $partner = $user->partner;
        if (empty($partner)) {
            $partner = new Partner();
            $user->partner()->save($partner);
        }
        $hotels = $user->hotels;
        $hotels->load(
            'translations',
            'place', 'place.translations',
            'images',
            'thumb',
            'rooms'
        );

        return view('cabinet.partner.hotels.index', compact(
            'user',
            'partner',
            'hotels'
        ));
    }

    public function create()
    {
        $user = Auth::user();
        return view('cabinet.partner.hotels.create', compact('user'));
    }

    public function store(Request $request)
    {

    }

    public function edit()
    {

    }


    public function update()
    {

    }

}