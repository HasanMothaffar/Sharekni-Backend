<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		$is_request_for_a_single_product = $request->route('id');
		return [
			'id' => $this->id,
			'name' => $this->name,
			'price' => $this->getPrice(),
			'description' => $this->description,
			'views' => $this->views,
			'expiry_date' => $this->expiry_date,
			'quantity' => $this->quantity,
			'category' => Category::find($this->category_id)->name,
			'reviews' => $this->when($is_request_for_a_single_product, $this->reviews()),
		];
	}

	/**
	 * Returns the price of the product based on its
	 * expiration date and the current date.
	 */
	public function getPrice()
	{
		return 2;

		$price = 0;
		$date_diff = time() - $this['expiry_date'];

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
