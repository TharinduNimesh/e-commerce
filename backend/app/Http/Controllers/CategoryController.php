<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function create(CreateCategoryRequest $request)
    {
        // get image from base64
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));

        $path = '/categories/' . uniqid() . '.png';
        Storage::disk('public')->put($path, $image, 'public');

        $category = Category::create([
            'name' => $request->name,
            'image' => $request->image,
        ]);

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ], 201);
    }
}
