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
			'original_price' => 'required|numeric|gt:0',
			'price_1' => 'required|numeric|gt:0|lt:original_price',
			'price_2' => 'required|numeric|gt:0|lt:price_1',
			'price_3' => 'required|numeric|gt:0|lt:price_2',
			'description' => 'required|string',
			'expiry_date' => 'required',
			'image' => 'required|image',
			'quantity' => 'required|integer|gt:0',
			'category_id' => 'exists:categories,id',
		];
	}
}
