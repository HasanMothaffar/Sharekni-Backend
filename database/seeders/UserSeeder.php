<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		User::factory()
			->count(10)
			->create();

		User::create([
			'name' => 'Hasan',
			'email' => 'hasan.mozafar@gmail.com',
			'password' => '12345678'
		]);
	}
}
