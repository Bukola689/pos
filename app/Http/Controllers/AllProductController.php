<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AllProductController extends Controller
{
    public function index()
    {
        $allProducts = Product::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'allProducts' => $allProducts
        ]);
    }

    public function productById(Product $product)
    {   
        return response()->json([
            'status' => true,
            'product' => $product
        ]);
    }

    public function searchAllProduct($search)
    {
        $product = Product::where('name', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($product) {
            return response()->json([
                'success' => true,
                'product' => $product
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'product not found'
            ]);
        }
    }
}
