<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		// First, filter by these fields (if available): Category, product name, expiration date
		// Then sort by name, price, expiration date (asc, desc)
		// Then return paginated results

		$category_id = $request->query('category');
		$name = $request->query('name');
		$sort = $request->query('sort');

		$products =
			Product::when($category_id, function ($query, $category_id) {
				return $query->where('category_id', $category_id);
			})
			->when($name, function ($query, $name) {
				return $query->where('name', 'like', "%$name%");
			})
			->when($sort, function ($query, $sort) {
				// Example request: ?sort=name_asc
				// Example 2 request: ?sort=price_desc

				$sort_fields = explode('_', $sort);

				$column = $sort_fields[0];
				$direction = $sort_fields[1];

				$valid_sort_columns = ['name', 'price', 'expiry_date'];
				if (!in_array($column, $valid_sort_columns)) return $query;

				return $query->orderBy($column, $direction);
			})->paginate(6);

		return response()->json([
			'data' => $products->items(),
			'current_page' => $products->currentPage(),
			'per_page' => $products->perPage(),
			'last_page' => $products->lastPage()
		], 200);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreProductRequest $request)
	{
		$validated = $request->validated();
		
		return Product::create($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		try {
			$product = Product::findOrFail($id);
			$product->views += 1;
			$product->save();

			return response()->json(['data' => $product], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$product = Product::find($id);

		if (!$product) {
			return response()->json(['message' => 'Product not found.'], 404);
		}

		// $product->newField = $request->newField;
		// $product->save();
		// return response()->json(['message' => 'Product updated successfully!', 'data' => $product], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		try {
			$product = Product::findOrFail($id);
			$product->delete();
			return response()->json(['message' => 'Product deleted successfully!'], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
	}
}
