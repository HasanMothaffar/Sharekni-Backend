<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
			'password' => bcrypt('12345678')
		]);
	}
}
