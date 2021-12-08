<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ReviewFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array
	 */
	public function definition()
	{
		return [
			'comment' => $this->faker->text(),
			'rating' => $this->faker->numberBetween(1, 5),
			'user_id' => DB::selectOne('SELECT id from users ORDER BY RAND() LIMIT 1')->id,
			'product_id' => DB::selectOne('SELECT id from products ORDER BY RAND() LIMIT 1')->id
		];
	}
}
