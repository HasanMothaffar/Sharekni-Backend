<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

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
		$limit = $request->query('limit', 6);

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
			})->paginate($limit);

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
		$image_upload_path = $request->file('image')->store('products', 'public');

		$product = new Product($request->safe()->all());
		$product['owner_id'] = auth()->id();
		$product['image_url'] = $image_upload_path;
		$product['likes'] = 0;
		$product['views'] = 0;
		$product->save();

		return response()->json([
			'message' => 'Product saved successfully!',
			'data' => new ProductResource($product)
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
	public function update(UpdateProductRequest $request, $id)
	{
		try {
			$product = Product::find($id);
			if (!Gate::allows('modify-product', $product)) {
				return response()->json([
					'message' => 'Your are not authorized to modify this product!'
				], 403);
			}

			if ($request->file('image')) {
				Storage::delete('public/' . $product->image_url);
				$image_upload_path = $request->file('image')->store('products', 'public');
				$product['image_url'] = $image_upload_path;
			}

			$request->validated();
			$product->update($request->safe()->all());
			$product->save();

			return response()->json([
				'message' => 'Product updated successfully!',
				'data' => new ProductResource($product)
			], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
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
			if (!Gate::allows('modify-product', $product)) {
				return response()->json([
					'message' => 'Your are not authorized to delete this product!'
				], 403);
			}
			
			$image_path = 'public/' . $product->image_url;
			if (Storage::exists($image_path)) {
				Storage::delete($image_path);
			}

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
			$user = auth()->user();

			if ($user->likesProduct($id)) {
				// Bad request
				return response()->json(['message' => 'Product already liked.'], 400);
			}

			$user->likes()->attach($id);
			$product->likes += 1;
			$product->save();

			return response()->json(['message' => 'Product liked succesfully!'], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
	}

	public function dislike($id)
	{
		try {
			$product = Product::findOrFail($id);
			$user = auth()->user();

			if (!$user->likesProduct($id)) {
				// Bad request
				return response()->json(['message' => 'Product is already not liked.'], 400);
			}

			$user->likes()->detach($id);
			$product->likes -= 1;
			$product->save();

			return response()->json(['message' => 'Product disliked succesfully!'], 200);
		} catch (ModelNotFoundException $e) {
			return response()->json(['message' => 'Product not found.'], 404);
		}
	}
}
