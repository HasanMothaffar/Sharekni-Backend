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
			'name' => 'required',
			'original_price' => 'required',
			'price_1' => 'required',
			'price_2' => 'required',
			'price_3' => 'required',
			'description' => 'required',
			'expiry_date' => 'required',
			'img_url' => 'required',
			'quantity' => 'required',
			'category_id' => 'required',
		];
    }
}
