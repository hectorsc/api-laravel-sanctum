<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware("auth:sanctum")->except(["index", "show"]);
    // }

    public function index()
    {
        return new CategoryCollection(Category::all());
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return $category;
    }

    public function show(Category $category)
    {
        $category = new CategoryResource($category);
        return $category;
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json();
    }
}
