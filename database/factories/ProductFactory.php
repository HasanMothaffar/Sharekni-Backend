<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		/**
		 * Prices are hardcoded because they have to follow
		 * a validation logic that's not possible to implement
		 * using the Faker library.
		 */
		$original_price = 300;

		return [
			'name' => $this->faker->name(),
			'original_price' => $original_price,
			'description' => $this->faker->text(),
			'quantity' => $this->faker->numberBetween(2, 30),
			'image_url' => $this->faker->imageUrl(),
			'expiry_date' => $this->faker->dateTimeBetween('2021-12-30', '2022-1-30'),
			'facebook_url' => $this->faker->url(),
			'phone_number' => $this->faker->phoneNumber(),
			'likes' => 0,
			'views' => 0,
			'category_id' => DB::selectOne('SELECT id from categories ORDER BY RAND() LIMIT 1')->id,
			'owner_id' => DB::selectOne('SELECT id from users ORDER BY RAND() LIMIT 1')->id
		];
	}
}
