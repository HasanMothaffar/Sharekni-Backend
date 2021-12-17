<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function register(RegisterRequest $request)
	{
		$validated = $request->validated();
		$fields = $request->safe()->all();

		$user = User::create([
			'name' => $fields['name'],
			'password' => bcrypt($fields['password']),
			'email' => $fields['email']
		]);

		return response()->json([
			'token' => $user->createToken('API Token')->plainTextToken,
			'data' => $user,
			'message' => 'Successfully created an account!'
		], 200);
	}

	public function login(LoginRequest $request)
	{
		$validated = $request->validated();
		$fields = $request->safe()->all();

		if (!Auth::attempt($fields)) {
			return response()->json([
				'message' => 'Invalid credentials'
			], 401);
		}

		$user = User::firstWhere('email', $fields['email']);
		return response()->json([
			'token' => $user->createToken('API Token')->plainTextToken,
			'data' => $user,
			'message' => 'Successfully logged in!'
		], 200);
	}

	public function logout()
	{
		auth()->user()->tokens()->delete();
		return response()->json([
			'message' => 'Logged out successfully!'
		], 200);
	}
}
