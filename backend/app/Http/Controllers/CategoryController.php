<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function create(CreateCategoryRequest $request)
    {
        $path = ImageController::store($request->image, 'categories');

        $category = Category::create([
            'name' => $request->name,
            'image' => $path,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }
}
