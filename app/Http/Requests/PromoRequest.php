<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'event_id'   => 'required',
            'name'       => 'required',
            'promoCode'  => 'required|unique:promos,promoCode',
            'description'=> 'required',
            'quantity'   => 'required|numeric|min:0',
            'validFrom'  => 'required|date',
            'validTo'    => 'required|date',
        ];

    }

    public function messages()
    {
        return [
            'event_id.required'   => 'Event ID is not found',
            'name.required'       => 'Promo name is empty',
            'promoCode.required'  => 'Promo code must not be empty',
            'promoCode.unique'    => 'Promo code is alrady exist',
            'description.required'=> 'Description must not be empty',
            'quantity.required'   => 'Quantity must not be empty',
            'quantity.nmumeric'   => 'Quantity must be a numeric',
            'validFrom.required'  => 'Valid From must not be empty',
            'validFrom.date'      => 'Valid From must not a date',
            'validTo.required'    => 'Valid To must not be empty',
            'validTo.date'        => 'Valid From must not a date',
        ];

    }

}
