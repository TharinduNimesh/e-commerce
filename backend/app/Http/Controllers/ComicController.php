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

    public function create(CreateComicRequest $request)
    {
        $comic = Comic::create([
            'title' => $request->title,
            'description' => $request->description,
            'images' => $request->images,
            'price' => $request->price,
            'categories' => $request->categories,
            'issued_at' => $request->issued_at,
            'created_by' => request()->user()->_id,
        ]);

        return response()->json([
            'message' => 'Comic created successfully',
            'comic' => $comic
        ], 201);
    }
}
