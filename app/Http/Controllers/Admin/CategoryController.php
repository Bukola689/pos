<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repository\Admin\Category\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {

        $categories = Cache::remember('categories', 60, function() {

            return Category::orderBy('id', 'desc')->get();
        });

        if($categories->isEmpty()) {
            return response()->json([
                'message'> 'Category Does Not Exist In Id'
            ]);
        }

        return response()->json([
            'status' => true,
            'categories' => $categories
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
          'name' => 'required|string|unique:categories,name|min:3|max:15'
       ]);

        if($validator->fails()) {
            return response()->json([
                'error message' => 'check your data and try again later'
            ]);
        }

        $data = $request->all();

        $this->category->saveCategory($request, $data);

        Cache::put('category', $data);

        return response()->json([
            'status' => true,
            'category' => 'Category Saved Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        
        $categoryId = Cache::remember('category:'. $id, 60, function() use($category) {

          return $category;

        });

        if(! $category) {
            return response()->json('Category not found for the id');
        }

        return response()->json([
            'category' => $categoryId
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $Category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:categories,name|min:3|max:15'
         ]);
  
          if($validator->fails()) {
              return response()->json([
                  'error message' => 'check your data and try again later'
              ]);
          }

          $data = $request->all();

        $this->category->updateCategory($request, $category, $data);

        Cache::put('category', $data);

        return response()->json([
            'status' => true,
            'category' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category) {
            return response()->json('Category does not exist');
        }

       $this->category->deleteCategory($category);

        Cache::pull('catehory');

        return response()->json([
            'message' => 'Category deleted Successfully',
        ]);
    }
}
