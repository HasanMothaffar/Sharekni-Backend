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
			'discounts' => 'required|json',
			'description' => 'required|string',
			'expiry_date' => 'required',
			'image' => 'required|image',
			'facebook_url' => 'string',
			'phone_number' => 'required_without:facebook_url|string',
			'quantity' => 'required|integer|gt:0',
			'category_id' => 'exists:categories,id',
		];
	}
}
