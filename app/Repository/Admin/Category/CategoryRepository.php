<?php

namespace App\Repository\Admin\Category;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements ICategoryRepository
{

    public function saveCategory(Request $request, array $data)
     {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
     }

     public function updateCategory(Request $request, Category $category, array $data)
    {
        $category->name = $request->name;
        $category->update();
    }

     public function deleteCategory(Category $category)
    {
        $category->delete();
    }

}