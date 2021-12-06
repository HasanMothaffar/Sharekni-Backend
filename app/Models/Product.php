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

	private function getPrice()
	{
		$price = 0;
		$date_diff = time() - $this['expiry_date'];

		if ($date_diff < 30 && $date_diff >= 15) {
			$price = $this['price-1'];
		} else if ($date_diff < 15 && $date_diff >= 7) {
			$price = $this['price-2'];
		} else {
			$price = $this['price-3'];
		}

		return $price;
	}
}
