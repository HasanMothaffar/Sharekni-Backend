<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
		/**
		 * Note that clients have to send a 'password_confirmation' field
		 */
		return [
			'name' => 'required|string|max:255',
			'email' => 'required|string|email|unique:users,email',
			'password' => 'required|string|min:6|confirmed'
		];
	}
}
