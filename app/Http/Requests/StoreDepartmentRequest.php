<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'name' => 'required|min:5',
            'description' => 'required',
            'websiteUrl' => 'required|url'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required!',
            'name.min' => 'Name field must be atleast 5 characters!',
            'description.required' => 'Description field is required!',
            'websiteUrl.required' => 'Website url field is required!',
            'websiteUrl.url' => 'Website url field should be a valid url!'
        ];
    }
}
