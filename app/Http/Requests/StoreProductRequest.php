<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
			'name' => 'required|string',
			'original_price' => 'required|gt:0',
			'price_1' => 'required|gt:0',
			'price_2' => 'required|gt:0',
			'price_3' => 'required|gt:0',
			'description' => 'required|string',
			'expiry_date' => 'required',
			'img_url' => 'required',
			'quantity' => 'required|gt:0',
			'category_id' => 'exists:categories,id',
		];
    }
}
