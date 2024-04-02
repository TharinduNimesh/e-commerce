<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComicRequest;
use App\Models\Comic;
use Illuminate\Http\Request;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::all();

        return response()->json([
            'status' => 'success',
            'comics' => $comics
        ]);
    }

    public function show($id)
    {
        $comic = Comic::find($id);

        return response()->json([
            'status' => 'success',
            'comic' => $comic
        ]);
    }

    public function create(CreateComicRequest $request)
    {
        $data = $request->validated();

        $images = [];
        foreach ($request->images as $image) {
            $path = ImageController::store($image, 'comics');
            array_push($images, $path);
        }

        $comic = Comic::create([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $images,
            'price' => $request->price,
            'has_discount' => $request->has_discount,
            'discount' => $request->discount,
            'categories' => $request->categories,
            'publisher' => $request->publisher,
            'issued_at' => $request->published_date,
            'created_by' => request()->user()->_id,
        ]);

        return response()->json([
            'message' => 'Comic created successfully',
            'comic' => $comic
        ], 201);
    }
}
