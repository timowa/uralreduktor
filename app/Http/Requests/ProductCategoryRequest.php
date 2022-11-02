<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'name' => ['required',Rule::unique('product_categories')->ignore($this->id)],
             'slug' => ['required',Rule::unique('product_categories')->ignore($this->id)]
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [

        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'=>'Укажите название категории',
            'name.unique_translation'=>'Названия категорий не должны повторяться',
            'slug.required'=>'Slug обязателен',
            'slug.unique'=>'Slug должен быть уникальным'
        ];
    }
}
