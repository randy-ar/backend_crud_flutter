<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return response()->json([
            'data' => ProductResource::collection($products)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:1',
            'description' => 'required|min:10',
            'image' => 'nullable|file|mimes:jpg,png,jpeg,gif|max:8048',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        if(!empty($request->file('image'))){
            $file = $request->file('image');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $path = public_path('images/products');
            $file->move($path, $filename);
            $product->image = 'images/products/' . $filename;
        }else{
            $product->image = 'placeholder.jpg';
        }


        
        $product->save();

        return response()->json([
            'session' => 'success',
            'message' => 'Product created successfully.',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { 
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'session' => 'error',
                'message' => 'Product not found.'
            ], 404);
        }
        return response()->json([
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    { 
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'session' => 'error',
                'message' => 'Product not found.'
            ], 404);
        }

        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:1',
            'description' => 'required|min:10',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Optional image update
        ]);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        if(!empty($request->file('image'))){
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image && File::exists(public_path($product->image))) {
                    if(!str_contains($product->image, 'placeholder')){
                        File::delete(public_path($product->image));
                    }
                }
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $path = public_path('images/products');
                $file->move($path, $filename);
                $product->image = 'images/products/' . $filename;
            }
        }

        $product->save();

        return response()->json([
            'session' => 'success',
            'message' => 'Product updated successfully.',
            'data' => new ProductResource($product)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { 
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'session' => 'error',
                'message' => 'Product not found.'
            ], 404);
        }

        // Delete image file if exists
        if ($product->image && File::exists(public_path($product->image))) {
            if(!str_contains($product->image, 'placeholder')){
                File::delete(public_path($product->image));
            }
        }

        $product->delete();

        return response()->json([
            'session' => 'success',
            'message' => 'Product deleted successfully.'
        ]);
    }
}
