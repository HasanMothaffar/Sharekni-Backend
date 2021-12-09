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
		'img_url',
		'quantity',
		'category_id',
	];

	protected $hidden = [
		'owner_id'
	];

	public function reviews()
	{
		return $this->hasMany(Review::class)
		->get()
		->map(function ($review) {
			$review['user'] = $review->user()->get();
			return $review;
		});
	}
}
