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
		$discounts = $this->discounts()->get();
		$price = $this->original_price;

		if ($discounts->count() == 0) {
			return $price;
		}

		$max_discount = 0;
		$max_diff = $discounts[0]['days_before_expiration'];

		foreach ($discounts as $discount) {
			$diff = $discount['days_before_expiration'] - $date_diff;
			if ($diff > 0 && $diff < $max_diff) {
				$max_discount = $discount['percentage'];
			}
		}

		return $price - ($max_discount / 100.0 * $price);
	}
}
