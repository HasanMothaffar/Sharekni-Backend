<?php

namespace App\Http\Resources;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
		/**
		 * Requests for /products should not return the product's reviews,
		 * while requests for /products/{productId} should do.
		 */
		$is_request_for_a_single_product = $request->route('id');

		/**
		 * The 'sanctum' guard here is very important. The /products route
		 * is not protected through the sanctum middleware, therefore calling
		 * auth()->user() without specifying the 'sanctum' guard
		 * would always return null.
		 */
		$is_product_liked = auth('sanctum')->check() ? auth('sanctum')->user()->likesProduct($this->id) : false;

		/**
		 * In this case, the product is fake and its image is hosted
		 * on another server.
		 */
		$is_image_external = str_contains($this->image_url, 'http');

		return [
			'id' => $this->id,
			'name' => $this->name,
			'price' => $this->getPrice(),
			'description' => $this->description,
			'expiry_date' => $this->expiry_date,
			'quantity' => $this->quantity,
			'image_url' => $is_image_external ? $this->image_url : asset(Storage::url($this->image_url)),
			'category' => Category::find($this->category_id)->name,
			'reviews' => $this->getReviewsWithUsers(),
			'views' => $this->views,
			'likes' => $this->likes,
			'facebook_url' => $this->facebook_url,
			'phone_number' => $this->phone_number,
			'is_liked' => $is_product_liked,
			'owner_id' => $this->owner_id
		];
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

	/**
	 * Fetch the user informatoin for each review and
	 * return the reviews collection.
	 */
	private function getReviewsWithUsers()
	{
		return $this->reviews()
			->get()
			->map(function ($review) {
				$review['user'] = $review->user()->get()->first();
				return $review;
			});
	}

	public function withResponse($request, $response)
	{
		$response->setEncodingOptions(JSON_UNESCAPED_SLASHES)->header('Content-Type', 'application/json');
	}
}
