<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'products' => new ProductCollection($this->products()->get()),
			'reviews' => $this->reviews()->get()
		];
	}

	public function withResponse($request, $response)
	{
		$response->setEncodingOptions(JSON_UNESCAPED_SLASHES);
	}
}
