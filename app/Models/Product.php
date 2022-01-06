<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


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
		'phone_number',
		'facebook_url'
	];

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}

	public function discounts()
	{
		return $this->hasMany(Discount::class);
	}

	public function likers()
	{
		return $this->belongsToMany(User::class, 'likes');
	}

	/**
	 * Returns the price of the product based on its
	 * expiration date and the current date.
	 */
	public function getPrice()
	{
		/**
		 * Reference on dealing with dates:
		 * https://stackoverflow.com/questions/46623065/how-to-subtract-two-dates-in-laravel5-4
		 */
		$expiry_date = Carbon::parse($this->expiry_date);
		$date_diff = Carbon::now()->diffInDays($expiry_date, false);
		$price = $this->original_price;

		if ($date_diff < 30 && $date_diff >= 15) {
			$price = $this['price_1'];
		} else if ($date_diff < 15 && $date_diff >= 7) {
			$price = $this['price_2'];
		} else if ($date_diff < 7 && $date_diff > 0) {
			$price = $this['price_3'];
		}

		return $price;
	}
}
