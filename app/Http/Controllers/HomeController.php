<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function allProducts()
    {
        $allProducts = Product::orderBy('id', 'desc')->get();

        return response()->json([
            'allProducts' => $allProducts,
        ]);
    }

    public function productById(Product $product)
    {   
        return response()->json([
            'status' => true,
            'product' => $product
        ]);
    }

    public function CompanyById(Company $company)
    {   
        return response()->json([
            'status' => true,
            'company' => $company
        ]);
    }

    public function SupplierById(Supplier $supplier)
    {   
        return response()->json([
            'status' => true,
            'supplier' => $supplier
        ]);
    }
    

    public function getProductByCategory(Category $category)
    {
        $productCats = Product::where('category_id', $category->id)->get();

        return response()->json([
            'productCats' => $productCats
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
