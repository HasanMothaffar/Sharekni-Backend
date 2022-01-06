<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
	public function index(Request $request, $productID)
	{
		// $sort = $request->query('sort');
		// $rating = $request->query('rating');

		// $reviews =
		// 	Review::where('product_id', $productID)
		// 	->when($rating, function ($query, $rating) {
		// 		return $query->where('rating', $rating);
		// 	})
		// 	->when($sort, function ($query, $sort) {
		// 		// TODO: Sort by date and rating

		// 		$direction = request()->query('dir', 'asc');

		// 		$valid_sort_columns = ['rating', 'date'];
		// 		$valid_directions = ['asc', 'desc'];


		// 		return $query->orderBy($sort_column, $direction);
		// 	})
		// 	->paginate(6);

		try {
			$product = Product::findOrFail($productID);
			$reviews =  $product->reviews()->get();
			return new ReviewCollection($reviews);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => __('products.not_found')], 404);
		}
	}

	public function store(Request $request, $productID)
	{
		try {
			$product = Product::findOrFail($productID);
			$request->validate([
				'comment' => 'required|string'
			]);

			$review = new Review([
				'comment' => $request->input('comment')
			]);
			$review['user_id'] = auth()->id();

			$product->reviews()->save($review);
			return response()->json([
				'message' => __('products.store_review_success'),
				'data' => new ReviewResource($review)
			], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => __('products.not_found')], 404);
		}
	}

	public function destroy($productID, $reviewID)
	{
		try {
			$product = Product::findOrFail($productID);
		} catch (ModelNotFoundException $e) {
			// return response()->json(['error' => $e]);
			return $e->getModel();
		}

		$review = Review::where('id', $reviewID)
			->where('product_id', $productID);
		// TODO: Separate handling missing products and reviews
		if (!$review) {
			return response()->json(['message' => 'Resource not found.', 404]);
		}

		Gate::authorize('delete-review', $review);
		$review->destroy();
		return response()->json(['message' => 'Review deleted successfully!'], 200);
	}
}
