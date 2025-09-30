<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        // $products = \App\Models\Product::with('category')->get()->map(function($item) {
        //     return [
        //         'id' => $item->id,
        //         'name' => $item->name,
        //         'description' => $item->description,
        //         'price' => $item->price,
        //         'category' => $item->category ? $item->category->name : 'Uncategorized'
        //     ];
        // });


        $products = \App\Models\Product::with('category')->get();
        $result = [];
        foreach($products as $product) {
            $result[] = [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category' => $product->category ? $product->category->description : 'Uncategorized'
            ];
        }


        return response()->json($result, 200);
    }
    public function store(Request $request) {
        \App\Models\Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'product_category_id' => $request->product_category_id,
            'price' => $request->price
        ]);

        return response()->json([
            'icon' => 'success',
            'title' => 'Success',
            'text' => 'Product created successfully'
        ], 200);
    }
}
