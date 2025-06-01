<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required',
            'whatsapp_number' => 'nullable',
            'email' => 'required',
            'national_id' => 'required',
            'branch_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'location_link' => 'nullable',
        ];
    }
}
