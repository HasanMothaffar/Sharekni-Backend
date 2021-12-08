<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		// 'App\Models\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		Gate::define('modify-product', function (User $user, Product $product) {
			return $user->id == $product->owner_id;
		});

		Gate::define('delete-review', function (User $user, Review $review) {
			return $user->id == $review->user_id;
		});
	}
}
