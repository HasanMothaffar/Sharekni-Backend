<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
		return [
			'name' => 'string',
			'original_price' => 'numeric|gt:0',
			'price_1' => 'numeric|gt:0|lt:original_price',
			'price_2' => 'numeric|gt:0|lt:price_1',
			'price_3' => 'numeric|gt:0|lt:price_2',
			'description' => 'string',
			'image' => 'image',
			'facebook_url' => 'string',
			'phone_number' => 'string',
			'quantity' => 'integer|gt:0',
			'category_id' => 'exists:categories,id',
		];
    }
}
