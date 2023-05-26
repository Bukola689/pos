<?php

namespace App\Repository\Admin\Category;

use App\Models\Category;
use Illuminate\Http\Request;

interface ICategoryRepository
{

    public function saveCategory(Request $request, array $data);

    public function updateCategory(Request $request, Category $category, array $data);

    public function deleteCategory(Category $category);
}