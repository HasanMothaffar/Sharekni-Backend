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
		$price_1 = 200;
		$price_2 = 100;
		$price_3 = 50;

		return [
			'name' => $this->faker->name(),
			'original_price' => $original_price,
			'price_1' => $price_1,
			'price_2' => $price_2,
			'price_3' => $price_3,
			'description' => $this->faker->text(),
			'quantity' => $this->faker->numberBetween(2, 30),
			'img_url' => $this->faker->text(),
			'expiry_date' => $this->faker->date(),
			'category_id' => DB::selectOne('SELECT id from categories ORDER BY RAND() LIMIT 1')->id,
			'owner_id' => DB::selectOne('SELECT id from users ORDER BY RAND() LIMIT 1')->id
		];
	}
}
