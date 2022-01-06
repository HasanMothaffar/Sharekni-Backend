<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('likes', function (Blueprint $table) {
			/**
			 * Reference on how to setup the likes table:
			 * https://stackoverflow.com/questions/57975383/add-likes-to-post-laravel
			 */
			$table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
			$table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('likes');
	}
}
