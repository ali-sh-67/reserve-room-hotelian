<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


/**
 *
 */
class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z ]+$/u',
            'surname' => 'required|regex:/^[a-zA-Z ]+$/u',
            'username' => 'required|unique:users,username',
            'password' => 'required|string|min:6|max:64'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام نمیتواند خالی باشد.',
            'name.regex' => 'نام فقط شامل حروف امگلیسی و فاصله میتواند باشد.',
            'surname.required' => 'نام خانوادگی نمیتواند خالی باشد.',
            'surname.regex' => 'نام خانوادگی فقط شامل حروف امگلیسی و فاصله میتواند باشد.',
            'username.required' => 'نام کاربری نمیتواند خالی باشد.',
            'username.unique' => 'نام کاربری نمیتواند تکراری باشد.',
            'password.required' => 'رمز نمیتواند خالی باشد.',
            'password.min' => 'پسورد نمیتواند کمتر از 6 کاراکتر باشد',
            'password.max' => 'پسورد نمیتو.اند بیشتر از 64 کاراکتر باشد',
        ];
    }
}
