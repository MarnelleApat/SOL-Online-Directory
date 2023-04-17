<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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

    // Function to add Prefix in the programCode after the validation is completed
    // public function passedValidation()
    // {
    //     $this->merge([
    //         'programCode' => "E-".$this->programCode,
    //     ]);
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'partner'     => 'required',
            'programCode'    => 'required|unique:events,programCode',
            'title'          => 'required',
            'description'    => 'required',
            'personIncharge' => 'required',
            'emailIncharge'  => 'required|email',
            'schedules'      => 'required',
            'categories'     => 'required',
            'registrationFee'=> 'required|numeric|min:0',
            'venue'          => 'required',
            'limitReg'       => 'numeric|min:0',
            'eventType'      => 'required',
        ];
    }

    /**
     * Customize the validation message
    */
    public function messages()
    {
        return [
            'title.required'            => 'Title must not be empty',
            'partner.required'          => 'Please select Partner',
            'programCode.unique'        => 'Program Code is already taken.',
            'description.required'      => 'Short description is required',
            'personIncharge.required'   => 'Event contact person is required',
            'emailIncharge.required'    => 'Contact email address is required',
            'emailIncharge.email'       => 'Contact email address is not valid',
            'registrationFee.required'  => 'Price is required',
            'schedules.required'        => 'Event must have schedule date',
            'limitReg.numeric'          => 'Must be a valid number',
            'eventType.required'        => 'Event type is required',
            'categories.required'       => 'Select atleast 1 category'
        ];
    }
}
