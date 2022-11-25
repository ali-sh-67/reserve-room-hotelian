<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 *
 */
class ReserveRequest extends FormRequest
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
            'breakfast' => 'required|boolean',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
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
            'breakfast.required' => 'داشتن یا نداشتن صبحانه را مشخص کنید',
            'breakfast.boolean' => 'فیلد صبحانه فقط این مقادیر را میتواند قبول کند:true||false',
            'from_date.required' => 'تاریخ شروع رزرو را مشخص کنید',
            'from_date.date' => 'برای فیلد تاریخ شروع رزرو فرمت تاریخ را رعایت کنید:2022-11-30 16:32:51',
            'to_date.required' => 'تاریخ پایان رزرو را مشخص کنید',
            'to_date.date' => 'برای فیلد تاریخ پایان رزرو فرمت تاریخ را رعایت کنید:2022-11-30 16:32:51',
        ];
    }
}
