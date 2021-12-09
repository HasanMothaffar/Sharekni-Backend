<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
		$sort_column = $request->query('sort');

		$products =
			Product::when($category_id, function ($query, $category_id) {
				return $query->where('category_id', $category_id);
			})
			->when($name, function ($query, $name) {
				return $query->where('name', 'like', "%$name%");
			})
			->when($sort_column, function ($query, $sort_column) {
				// Example request 1: ?sort=name&dir=asc
				// Example request 2: ?sort=price&dir=desc
				$valid_sort_columns = ['name', 'price', 'expiry_date'];
				$valid_sort_directions = ['asc', 'desc'];
				$direction = request()->query('dir', 'asc');

				if (
					!in_array(strtolower($sort_column), $valid_sort_columns) ||
					!in_array(strtolower($direction), $valid_sort_directions)
				) {
					return $query;
				}

				return $query->orderBy($sort_column, $direction);
			})->paginate(6);

		return new ProductCollection($products);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreProductRequest $request)
	{
		$validated = $request->validated();

		$product = Product::create($request->safe()->all());
		$product['owner_id'] = auth()->id();
		$product->save();

		return response()->json([
			'message' => 'Product saved successfully!',
			'data' => $product
		], 200);
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

			return (new ProductResource($product))->response();

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
		Gate::authorize('modify-product', $product);

		$request->validated();

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
			Gate::authorize('modify-product', $product);
			$product->delete();
			return response()->json(['message' => 'Product deleted successfully!'], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
	}

	public function like($id)
	{
		try {
			$product = Product::findOrFail($id);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
	}
}
