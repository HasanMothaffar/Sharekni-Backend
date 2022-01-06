
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

			$table->integer('views')->default(0);
			$table->longText('description');
			$table->date('expiry_date');
			$table->text('image_url');

			/* -- Only one of these two is required -- */
			$table->text('facebook_url')->nullable();
			$table->text('phone_number')->nullable();

			$table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
			$table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
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
