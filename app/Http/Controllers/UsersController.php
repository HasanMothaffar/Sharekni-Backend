<?php

namespace App\Http\Controllers;

class UsersController extends Controller
{
	public function profile()
	{
		// TODO: Make a resource class for this response?
		$user = auth()->user();
		$user['products'] = $user->products()->get();
		$user['reviews'] = $user->reviews()->get();
		return $user;
	}
}
