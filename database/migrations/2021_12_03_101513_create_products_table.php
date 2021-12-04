<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->double('original_price');
			$table->double('price_1');
			$table->double('price_2');
			$table->double('price_3');
			$table->longText('description');
			$table->date('expiry_date');
			$table->text('img_url');
			$table->integer('quantity')->default(1);
			$table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
			// $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('products');
	}
}
