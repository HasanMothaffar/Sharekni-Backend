<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index (Request $request, $id) {
		$sort = $request->query('sort');
		$rating = $request->query('rating');

		$reviews =
			Review::where('product_id', $id)
			->when($rating, function ($query, $rating) {
				return $query->where('rating', $rating);
			})
			->when($sort, function ($query, $sort) {
				// TODO: Sort by date and rating

				$direction = request()->query('dir', 'asc');

				$valid_sort_columns = ['rating', 'date'];
				$valid_directions = ['asc', 'desc'];


				return $query->orderBy($sort_column, $direction);
			})
			->paginate(6);

		return $reviews;
	}

	public function destroy($id) {
		try {
			$review = Review::findOrFail($id);
			$review->destroy();
			return response()->json(['message' => 'Review deleted successfully!'], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Review not found.'], 404);
		}
	}
}
