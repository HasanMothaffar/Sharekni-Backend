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

			/**
			 * original_price: date > 30 days
			 * price_1: date between 15 and 30
			 * price_2: date between 7 and 15
			 * price_3: date < 7
			 *
			 * where date = product_expiry_date - current_date()
			 */
			$table->double('original_price');
			$table->double('price_1');
			$table->double('price_2');
			$table->double('price_3');

			$table->integer('views')->default(0);
			$table->longText('description');
			$table->date('expiry_date');
			$table->text('img_url');
			$table->integer('quantity')->default(1);
			$table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();

			// TODO: Seems like I'm doing a mistake here making the 'owner_id' column nullable. Read more about it.
			$table->foreignId('owner_id')->nullable()->constrained('users')->cascadeOnDelete();
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
