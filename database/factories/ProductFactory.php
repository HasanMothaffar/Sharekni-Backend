<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'name' => $this->faker->name(),
			'original_price' => $this->faker->numberBetween(2, 30),
			'price_1' => $this->faker->numberBetween(2, 30),
			'price_2' => $this->faker->numberBetween(2, 30),
			'price_3' => $this->faker->numberBetween(2, 30),
			'description' => $this->faker->text(),
			'quantity' => $this->faker->numberBetween(2, 30),
			'category_id' => $this->faker->numberBetween(1, 10),
			'img_url' => $this->faker->text(),
			'expiry_date' => $this->faker->date()
		];
	}
}
