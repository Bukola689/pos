<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Repository\Admin\Product\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }

        /**
     * Display product by its category resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getProductByCategory(Request $request)
     {

        $categoryId = $request->query('categoryId');

        $products = Product::whereHas('category', function($query) use($categoryId) { 

            if($categoryId) {
                $query->where('category_id', $categoryId);
            }

        })->get();

        return response()->json([
           'category-product' => $products
        ]);
     }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryId)
    {
        $products = Cache::remember('products', 60, function () use ($categoryId) {

            //return  Product::orderBy('id', 'desc')->paginate(5);

            return Product::whereHas('category', function($query) use($categoryId) {
                $query->where('category_id', $categoryId);
            })->get();

        });

        if($products->isEmpty()) {
            return response()->json([
                'error message' => 'Product is Empty'
            ]);
        }

        return response()->json([
            'status' => true,
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
       
       $data = $request->all();

        $this->product->storeProduct($request, $data);

        Cache::put('product', $data);

       
        return response()->json([
            'message' => 'Product Created Successfully !'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $categoryId, $id)
    {
         $product = Cache::remember('product:'. $request->id, 60, function() use ($categoryId, $id) {
            //return Product::find($id);

            return Product::whereHas('category', function($query) use($categoryId) {
                $query->where('category_id', $categoryId);
            })->find($id);

         });

        if(! $product) {
            return response()->json([
                'message' => 'Product Does Not Exist For This Id'
            ]);
        }

        return response()->json([
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request,$id)
    {
        $product = Product::find($id);

        if(! $product) {
            return response()->json([
                'error message' => 'Product Does Not Exist For This Id'
            ]);
        }

      $data = $request->all();

      $product = $this->product->updateProduct($request, $id, $data);

      Cache::put('product', $data);

        return response()->json([
            'product' => $product,
            'message' => 'Product Updated Successfully !'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if(! $product) {
            return response()->json([
                'error message' => 'Product Does Not Exist For This Id'
            ]);
        }

        $this->product->deleteProduct($product);

        Cache::pull('product');

        if($product) {
            return response()->json([
                'product' => $product,
                'message' => 'Product Delelted Successfully !'
            ]);
    
           }
    
           else {
            return response()->json([
                'status' => false,
                'message' => 'Product Not Found !'
            ]);
           }
    }

   
    public function searchProduct($search)
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
