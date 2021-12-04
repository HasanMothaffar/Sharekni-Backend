<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
		$names = [
			'App',
			'Ball',
			'Toy',
			'Electronic',
			'Makeup',
			'Game',
			'Hair'
		];

		$product_names = [
			'Another product',
			'Product',
			'hasan product',
			'ebola',
			'kimola product',
			'hair shampoo',
			'yes no product',
		];

		for ($i = 0; $i < count($names); $i++) {
			DB::table('categories')->insert([
				'name' => $names[$i]
			]);
		}

		for ($i = 0; $i < count($names); $i++) {
			DB::table('products')->insert([
				'name' => $product_names[$i],
				'category_id' => $i + 1
			]);
		}
	}
}
