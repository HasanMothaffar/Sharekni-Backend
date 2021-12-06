<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		// \App\Models\User::factory(10)->create();


		User::factory()
			->count(10)
			->create();

		User::create([
			'name' => 'Hasan',
			'email' => 'hasan.mozafar@gmail.com',
			'password' => '12345678'
		]);

		Category::factory()
			->count(10)
			->create();

		Product::factory()
			->count(30)
			->create();

		Review::factory()
			->count(10)
			->create();
	}
}
