<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
	 *
	 * If the product that the user wants to delete belongs to
	 * them, then the user can delete it.
     *
     * @return bool
     */
    public function authorize()
    {
		/*
			return userOwnsProduct($id);
		*/
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
