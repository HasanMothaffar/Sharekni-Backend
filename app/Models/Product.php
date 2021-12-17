<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	use HasFactory;

	protected $fillable = [
		'name',
		'original_price',
		'price_1',
		'price_2',
		'price_3',
		'description',
		'expiry_date',
		'quantity',
		'category_id',
		'phone_number',
		'facebook_url'
	];

	protected $hidden = [
		'owner_id'
	];

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function likers()
	{
		return $this->belongsToMany(User::class, 'likes');
	}
}
