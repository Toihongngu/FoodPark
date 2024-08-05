<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'thumb_image' => ['nullable', 'image' ,'max:3000'],
            'name' => ['required','max:255'],
            'category' => ['required', 'integer'],
            'price' => ['required','numeric'],
            'offer_price' => ['nullable','numeric'],
            'short_description'=>['required', 'max:500'],
            'long_description'=>['required'],
            'sku'=>['nullable','max:255'],
            'seo_title' =>['nullable','max:255'],
            'seo_description' =>['nullable','max:255'],
            'show_at_home' => ['required', 'boolean'],
            'status' => ['required', 'boolean']
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('status') == false && $this->input('show_at_home') == true) {
                $validator->errors()->add('show_at_home', 'The show_at_home field cannot be true when status is false.');
            }
        });
    }
}
