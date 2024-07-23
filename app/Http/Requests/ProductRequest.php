<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|image|mimes:png,jpg,jpeg|max:2048',
            'name' => 'required|string',
            'price' => 'required|string',
            'quantity' => 'required|string',
            'data' => 'required'
        ];
    }

    public function  message()
    {
        return [
            'image' => __('words.Please enter a product image'),
            'name' => __('words.Please enter a product name'),
            'price' => __('words.Please enter a product price'),
            'quantity' => __('words.Please enter a product quantity'),
            'data' => __('words.Please enter a product data'),
        ];
    }
}
