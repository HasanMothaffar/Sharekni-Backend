<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
	private $categories = [
		'Electronics',
		'Food',
		'Cosmetics',
		'Sports',
		'Clothes',
		'Shoes',
	];
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		foreach ($this->categories as $name) {
			Category::create([
				'name' => $name
			]);
		}
	}
}
