<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/categories', [CategoriesController::class, 'index']);

Route::get('/products', [ProductsController::class, 'index']);
Route::get('/products/{id}', [ProductsController::class, 'show']);

Route::group(['middleware' => 'auth:sanctum'], function () {
	Route::get('/profile', [UsersController::class, 'profile']);
	Route::post('/logout', [AuthController::class, 'logout']);

	Route::prefix('products')->group(function () {
		Route::post('/', [ProductsController::class, 'store']);
		Route::patch('/{id}', [ProductsController::class, 'update']);
		Route::delete('/{id}', [ProductsController::class, 'destroy']);

		// LIKES
		Route::post('/{id}/like', [ProductsController::class, 'like']);
		Route::post('/{id}/dislike', [ProductsController::class, 'dislike']);

		// REVIEWS
		Route::get('/{id}/reviews', [ReviewsController::class, 'index']);
		Route::post('/{id}/reviews', [ReviewsController::class, 'store']);
		Route::delete('/{id}/reviews/{reviewID}', [ReviewsController::class, 'destroy']);
	});
});
