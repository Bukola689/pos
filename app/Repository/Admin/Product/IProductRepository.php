<?php

namespace App\Repository\Admin\product;

use App\Models\product;
use Illuminate\Http\Request;

interface IProductRepository
{
     public function storeProduct(Request $request, array $data);

     public function updateProduct(Request $request, Product $product, array $data);

     public function deleteProduct(product $product);
}