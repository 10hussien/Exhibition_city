<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'image_department' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'name_department' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'image_department' => __('words.Please enter a department image '),
            'name_department' => __('words.Please enter the department name'),
        ];
    }
}
