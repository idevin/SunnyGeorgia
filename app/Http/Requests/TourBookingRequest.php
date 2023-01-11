<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tour_id' => 'required|exists:tours,id',
            'date_in' => 'required',
//            'add_transfer' => 'boolean',
//            'add_flight' => 'boolean',
//            'food' => 'integer',

//            'accommodations' => 'required|array',
//            'accommodations.*.id' => 'exists:accommodations',
//            'accommodations.*.adults' => 'required',
//            'accommodations.*.kids' => 'required',
//            'accommodations.*.additional' => 'required',

            'cost' => 'required',
        ];
    }
}
