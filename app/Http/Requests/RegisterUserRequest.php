<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterUserRequest extends FormRequest
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
            'nirc'                  => 'required',
            'username'              => 'required|unique:users',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'email'                 => 'required|string|email|max:255|unique:users',
            'firstName'             => 'required|string|max:255',
            'lastName'              => 'required|string|max:255',
            'phoneNumber'           => 'required',
            'address'               => 'required',
            'city'                  => 'required',
            'postalCode'            => 'required',
            'country'               => 'required',
            'church'                => 'string',
            'gender'                => 'required',
            'billingAddress'        => 'required',
            'shippingAddress'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'Password & confirm password must match'
        ];
    }
}
