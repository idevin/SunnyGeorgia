<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcursionBookingRequest extends FormRequest
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
            'excursion_id' => 'required',
            'excursion_availability_id' => 'required',
            'amount_adults' => 'required',
//            'amount_kids' => 'required',
        ];
    }
}
