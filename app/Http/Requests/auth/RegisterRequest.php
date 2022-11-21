<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-z]$/',
            'surname' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|string|min:6|max:64'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'نام نمیتواند خالی باشد.',
            'name.regex' => 'نام فقط شامل حروف امگلیسی و فاصله میتواند باشد.',
            'surname.required' => 'نام خانوادگی نمیتواند خالی باشد.',
            'username.required' => 'نام کاربری نمیتواند خالی باشد.',
            'username.unique' => 'نام کاربری نمیتواند تکراری باشد.',
            'password.required' => 'رمز نمیتواند خالی باشد.',
            'password.min' => 'پسورد نمیتواند کمتر از 6 کاراکتر باشد',
            'password.max' => 'پسورد نمیتو.اند بیشتر از 64 کاراکتر باشد',
        ];
    }
}
