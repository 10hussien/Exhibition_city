<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'department' => 'required|string',
            'company_logo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'company_name' => 'required|string',
            'company_address' => 'required|string',
            'company_email' => 'required|email|string',
            'bio' => 'required|string',
            'facebook' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'department' => __('words.Please enter the company department'),
            'company_logo' => __('words.Please enter your company logo'),
            'company_name' => __('words.Please enter your company name'),
            'company_address' => __('words.Please enter the company  address'),
            'company_email' => __('words.Please enter your company email'),
            'bio' => __('words.Please enter your company description'),
            'facebook' => __('words.Please enter the company Facebook'),
        ];
    }
}
