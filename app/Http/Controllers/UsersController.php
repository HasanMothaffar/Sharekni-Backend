<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;

class UsersController extends Controller
{
	public function profile()
	{
		return new UserResource(auth()->user());
	}
}
