<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class UsersController extends Controller
{
	public function profile()
	{
		$user = auth()->user();
		$user['products'] = Product::where('owner_id', '=', auth()->id())->get();
		return $user;
	}
}
