<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProfileRequest extends FormRequest
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
            'name'=>'required',
            'email' => 'required|email|unique:admins,email,'.$this->id,
            'password' => 'nullable|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>__('admin\dashboard.name field is required'),
            'email.required'=>__('admin\dashboard.email field is required'),
            'email.email'=>__('admin\dashboard.email is not valid'),
            'email.unique'=>__('admin\dashboard.email is already taken'),
            'password.required'=>__('admin\dashboard.password field is required'),
            'password.min'=>__('admin\dashboard.password must be more than 6 letters'),
            'password.confirmed'=>__('admin\dashboard.password does not match'),
        ];
    }
}
