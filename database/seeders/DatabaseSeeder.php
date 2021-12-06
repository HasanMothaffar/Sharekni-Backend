<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run()
	{
		/**
		 * Please make sure that the UserSeeder and CategorySeeder
		 * classes are called first! Some values in the classes
		 * below them depend on ids that are supposed to be initialized first.
		 */
		$this->call([
			UserSeeder::class,
			CategorySeeder::class,
			ProductSeeder::class,
			ReviewSeeder::class
		]);
	}
}
