<?php

namespace App\Repository\Admin\Product;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ProductRepository implements IProductRepository
{

     public function storeProduct(Request $request,array $data)
     {
      $product = new Product();
      $product->name = $request->name;
      $product->description = $request->description;
      $product->category_id = $request->category_id;
      $product->price = $request->price;
      $product->discount = $request->discount;
      $product->quantity = $request->quantity;
      $product->alert_stock = $request->alert_stock;
      $product->save();
     }

     public function updateProduct(Request $request,Product $product, array $data)
     {
      $product->name = $request->name;
      $product->description = $request->description;
      $product->category_id = $request->category_id;
      $product->price = $request->price;
      $product->discount = $request->discount;
      $product->quantity = $request->quantity;
      $product->alert_stock = $request->alert_stock;
      $product->update();
     }

     public function deleteProduct(Product $product)
     {
        $product->delete();
     }

}