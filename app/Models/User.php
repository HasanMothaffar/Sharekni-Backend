<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var string[]
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'updated_at',
		'created_at'
	];

	public function products()
	{
		return $this->hasMany(Product::class, 'owner_id');
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function likes()
	{
		return $this->belongsToMany(Product::class, 'likes');
	}

	/**
	 * Returns whether the user likes a specific product or not.
	 *
	 * @return bool
	 */
	public function likesProduct($productId)
	{
		return boolval(
			$this->likes()
				->wherePivot('user_id', auth('sanctum')->id())
				->wherePivot('product_id', $productId)
				->get()
				->count()
		);
	}
}
